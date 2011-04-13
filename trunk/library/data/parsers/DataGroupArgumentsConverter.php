<?php

class DataGroupArgumentsConverter extends NonDynamicObject implements IDataGroupConverter{
	const ARGUMENTS_GROUP_SEPARATOR = '-';
	static public function load(){
		global $argv;
		/** @var array */
		$parameters = array();
		if(defined('STDIN') && $argv){ // CLI
			$parameters = self::convertArguments($argv);
		}
		/** @var IDataGroup */
		$group = new DataGroup();
		self::convertInternal($parameters, $group);
		return $group;
	}
	static public function convert($array, IDataGroup $group=null){
		if(!$group) $group = new DataGroup();
		self::convertInternal($array, $group);
		return $group;
	}
	static private function convertInternal($array, IDataGroup $group){
		/** @var IDataContainerManager */
		$dataManager = $group->dataManager();
		/** @var IDataGroupManager */
		$groupManager = $group->groupManager();
		foreach($array as $key=>$value){
			if(strpos($key, self::ARGUMENTS_GROUP_SEPARATOR)===false){
				if(is_array($value)){
					reset($value);
					if(!is_int(key($value))){
						$item = new DataGroup();
						$groupManager->add($key, $item);
						self::integrateArray($item, $value);
						continue;
					}
				}
				$dataManager->set($key, $value);
			}else{
				//echo " ---- $key \r\n";
				self::putArgumentToPlace($group, explode(self::ARGUMENTS_GROUP_SEPARATOR, $key), $value);
			}
		}
		return $group;
	}
	static private function putArgumentToPlace(IDataGroup $group, $names, $value){
		$name = array_shift($names);
		if(count($names)){ // group
			$index = (int)$name;
			/** @var IDataGroup */
			$item = null;
			if((string)$index==$name && $group instanceof IDataLevels){
				/** @var IDataLevelsManager */
				$levelsManager = $group->levelsManager();
				if($levelsManager->has($index)){
					//echo " - level get($index) \r\n";
					$item = $levelsManager->get($index);
				}else{
					//echo " - level new($index) \r\n";
					$item = new DataGroup();
					$levelsManager->set($index, $item);
				}
			}else{
				/** @var IDataGroupManager */
				$groupManager = $group->groupManager();
				if($groupManager->has($name)){
					//echo " - group get($name) \r\n";
					$item = $groupManager->get($name);
				}else{
					//echo " - group new($name) \r\n";
					$item = new DataGroup();
					$groupManager->set($name, $item);
					$item = $groupManager->get($name);
				}
			}
			self::putArgumentToPlace($item, $names, $value);
		}else{ // value
			/** @var IDataContainerManager */
			$dataManager = $group->dataManager();
			//echo " - value new($name) \r\n";
			$dataManager->set($name, $value);
		}
	}
	static private function convertArguments($input){
		$output = array();
		$name = null;
		foreach($input as $value){
			if($name){
				if(array_key_exists($name, $output)){
					if(is_array($output[$name])){
						array_push($output[$name], $value);
					}else{
						$output[$name] = array($output[$name], $value);
					}
				}else{
					$output[$name] = $value;
				}
				$name = null;
			}else{
				if(strlen($value)>1 && $value[0]==self::ARGUMENTS_GROUP_SEPARATOR){
					$name = substr($value, 1);
					if($name!=trim($name, self::ARGUMENTS_GROUP_SEPARATOR)){
						$name = null;
					}
				}
			}
		}
		return $output;
	}
}

?>