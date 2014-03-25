<?php

class IGBinaryProtocolService extends NonDynamicObject implements IPAPProtocolService {
	const EXTENSION = 'igbinary';
	static private $_instance;
	private $_eop;
	private $_rest = array();
	public function __construct($eop=IPAPProtocolService::DEFAULT_EOP){
		$this->_eop = chr(is_int($eop) ? $eop : IPAPProtocolService::DEFAULT_EOP);
	}
	public function name(){
		return self::EXTENSION;
	}
	/**
	 * Any character that will be interpreted as end of packet
	 * @return string
	 */
	public function eop(){
		return $this->_eop;
	}
	private function packData($data){ 
		return addcslashes(igbinary_serialize($data), $this->_eop.'\\');
	}
	private function unpackData($data){
		return igbinary_unserialize(stripcslashes($data));
	}
	public function readTransport($string){
		/** @var array */ $parts = explode($this->_eop, $string);
		/** @var array */ $list = array();
		foreach($parts as /** @var string */ $part){
			if($part==='') continue;
			/** @var PAPProtocolTransport */ $transport = self::unpackData($part);
			if($transport instanceof PAPProtocolTransport){
				array_push($list, $transport);
			}else{
				$name = '';
				if(is_object($transport)){
					/** @var ReflectionObject */ $reflection = new ReflectionObject($transport);
					$name = $reflection->getName();
				}else{
					$name = gettype($transport);
				}
				throw new Exception('DefaultProtocolService Error: Received string is not an instance of PAPProtocolTransport - instance of "'.$name.'" given.');
			}
		}
		return $list;
	}
	public function readEntities(PAPProtocolTransport $transport){
		$list = array();
		$transportId = $transport->id;
		$transportIndex = $transport->index;
		if(!isset($this->_rest[$transportId])) $this->_rest[$transportId] = array();
		if(isset($this->_rest[$transportId][$transportIndex])) return $list;
		$this->_rest[$transportId][$transportIndex] = PAPUtils::unprotectString($transport->data);
		/** @var string[] */ $rest = $this->_rest[$transportId];
		$count = $transport->count;
		$finished = true;
		for($index=0; $index<$count; $index++){
			if(!isset($rest[$index])){
				$finished = false;
				break;
			}
			/** @var */ $string = $rest[$index];
			if(!$string) continue;
			while(($position = strpos($string, $this->_eop))!==false){
				$entity = $this->readEntity(substr($string, 0, $position));
				if($entity){
					array_push($list, $entity);
				}
				$string = substr($string, $position+1);
			}
			if($string && isset($rest[$index+1])){
				$rest[$index+1] = $this->_rest[$transportId][$index+1]  = $string.$rest[$index+1];
				$string = '';
			}
			$this->_rest[$transportId][$index] = $string;
		}
		if($finished){
			unset($this->_rest[$transportId]);
		}
		return $list;
	}
	public function readEntity($string){
		return self::unpackData($string);
	}
	public function writeTransport($id, $destinationId, $entities, $confirm, $maxPacketSize=0){
		$list = array();
		/** @var string */ $serialized = '';
		foreach($entities as /** @var PAPProtocolEntity */ $entity){
			$serialized .= $this->writeEntity($entity).$this->_eop;
		}
		$serialized = PAPUtils::protectString($serialized);
		if($maxPacketSize){
			/** @var string[] */ $parts = str_split($serialized, $maxPacketSize);
			$count = count($parts);
			foreach($parts as /** @var int */ $key => /** @var string */ $part){
				array_push($list, self::packData(new PAPProtocolTransport($id, $destinationId, $part, $key, $count, $confirm)).$this->_eop);
			}
		}else{
			array_push($list, self::packData(new PAPProtocolTransport($id, $destinationId, $serialized, 0, 1, $confirm)).$this->_eop);
		}
		return $list;
	}
	public function writeEntity(PAPProtocolEntity $entity){
		return self::packData($entity);
	}
	public function isCompatible(IPAPProtocolService $service){
		return $service instanceof IGBinaryProtocolService;
	}
	public function isSupported(){
		return extension_loaded(self::EXTENSION);
	}
	static public function getInstance(IDataGroup $config=null){
		if(!extension_loaded(self::EXTENSION)){
			throw new Exception('IGBinaryProtocolService Error: PHP Extension "'.self::EXTENSION.'" must be loaded.');
		}
		/** @var int|boolean */ $eop = $config && $config->hasValue('eop') ? (int)$config->value('eop') : false;
		return new DefaultProtocolService($eop);
	}
}

?>