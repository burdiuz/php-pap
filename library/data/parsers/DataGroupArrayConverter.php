<?php

class DataGroupArrayConverter extends NonDynamicObject implements IDataGroupConverter{
	static public function convert($array, IDataGroup $group=null){
		if(!$group) $group = new DataGroup();
		self::convertInternal($array, $group);
		return $group;
	}
	static private function convertInternal($array, IDataGroup $group){
		if(!$group) $group = new DataGroup();
		/** @var IDataContainerManager */
		$dataManager = $group->dataManager();
		/** @var IDataGroupManager */
		$groupManager = $group->groupManager();
		foreach($array as $key=>$value){
			if(is_array($value)){
				reset($value);
				if(!is_int(key($value))){
					$item = new DataGroup();
					$groupManager->add($key, $item);
					self::convertInternal($value, $item);
					continue;
				}
			}
			$dataManager->set($key, $value);
		}
		return $group;
	}
}

?>