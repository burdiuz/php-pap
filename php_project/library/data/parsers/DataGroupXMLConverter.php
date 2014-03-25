<?php

class DataGroupXMLConverter extends NonDynamicObject implements IDataGroupConverter{
	/**
	 * Parse XML file contents into config data
	 * @param string $path
	 * @param IDataGroup $group
	 * @return IDataGroup
	 */
	static public function load($path, IDataGroup $group=null){
		return self::parse(file_get_contents($path), $group);
	}
	/**
	 * Parse XML formatted string into config data
	 * @param string $data
	 * @param IDataGroup $group
	 * @return IDataGroup
	 */
	static public function convert($data, IDataGroup $group=null){
		if(!$group) $group = new DataGroup();
		/** @var XMLReader */$reader = new XMLReader();
		$reader->XML($data, 'utf-8', LIBXML_NOBLANKS | LIBXML_NOCDATA);
		do{
			$reader->read();
		}while($reader->nodeType!=XMLReader::ELEMENT);
		if($reader->nodeType==XMLReader::ELEMENT){
			self::parseInternal($reader, $group);
		}
		return $group;
	}
	static private function parseInternal(XMLReader $reader, IDataGroup $group, $name = null){
		/** @var IDataContainerManager */$dataManager = $group->dataManager();
		/** @var IDataGroupManager */    $groupManager = $group->groupManager();
		while($reader->read()){
			if($reader->nodeType==XMLReader::ELEMENT){
				if($name){
					//echo ' +1 '.$reader->name."\n";
					$item = new DataGroup();
					self::parseInternal($reader, $item, $reader->name);
					$groupManager->add($name, $item);
					$name = null;
					//echo ' - '.$reader->name."\n";
				}else{
					$name = $reader->localName;
					//echo ' +0 '.$name."\n";
				}
			}elseif($reader->nodeType==XMLReader::TEXT){
				if($name){
					$value = trim($reader->value);
					if($dataManager->has($name)){
						$prevValue = $dataManager->get($name);
						if(!is_array($prevValue)) $prevValue = array($prevValue);
						array_push($prevValue, $value);
						$dataManager->set($name, $prevValue);
						//echo 'add '.$name.' = '.$value."\n";
					}else{
						$dataManager->set($name, $value);
						//echo 'new '.$name.' = '.$value."\n";
					}
				}
			}elseif($reader->nodeType==XMLReader::END_ELEMENT){
				if($name){
					//echo ' - '.$name."\n";
					$name = null;
				}else{
					break;
				}
			}
		}
	}
}

?>