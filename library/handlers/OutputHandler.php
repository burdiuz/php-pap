<?php
class OutputHandler extends Handler {
	const USE_ECHO = 0;
	const USE_PRINTR = 1;
	const DEFAULT_SEPARATOR = ' ';
	const ARRAY_SEPARATOR = ', ';
	private $_type;
	private $_separator;
	private $_expandArrays;
	public function __construct($type=USE_ECHO, $separator=self::DEFAULT_SEPARATOR, $expandArrays=true){
		parent::__construct(null);
		$this->_type = $type;
		$this->_separator = $separator;
		$this->_expandArrays = $expandArrays;
	}
	public function call($arguments){
		switch($this->_type){
			case self::USE_ECHO:
			default:
				if($this->_expandArrays){
					foreach($arguments as $key=>$value){
						if(is_array($value)){
							$arguments[$key] = self::expandArray($value, self::ARRAY_SEPARATOR);
						}
					}
				}
				echo implode($this->_separator, $arguments);
			break;
			case self::USE_PRINTR:
				print_r($arguments);
			break;
		}
	}
	public function apply(){
		$this->call(func_get_args());
	}
	static private function expandArray($arguments, $glue){
		foreach($arguments as $key=>$value){
			if(is_array($value)){
				$arguments[$key] = $key.'='.self::expandArray($value, $glue);
			} 
		}
		return '['.implode($glue, $value).']';
	}
}

?>