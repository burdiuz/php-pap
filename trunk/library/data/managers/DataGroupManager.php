<?php

class DataGroupManager extends NonDynamicObject implements IDataGroupManager {
	/**
	 * RAW groups data holder
	 * @var ValueHolder
	 */
	private $_groups;
	public function __construct(ValueHolder $groups){
		$this->_groups = $groups;
	}
	public function has($name){
		return isset($this->_groups->value[$name]) && $this->_groups->value[$name]->hasLevels();
	}
	public function get($name){
		return $this->_groups->value[$name];
	}
	public function add($name, IDataContainer $group){
		if($this->has($name)){
				/** @var IDataLevels */ $levels = $this->_groups->value[$name];
				/** @var IDataLevelsManager */ $manager = $levels->levelsManager();
			if($group instanceof IDataLevels){
				foreach($group as /** @var IDataContainer */ $item){
					$manager->add($group);
				}
			}else{
				$manager->add($group);
			}
		}else{
			$this->set($name, $group);
		}
	}
	public function set($name, IDataContainer $group){
		if($group instanceof IDataLevels) $this->_groups->value[$name] = $group;
		else $this->_groups->value[$name] = new DataLevels($group);
	}
	public function remove($name){
		unset($this->_groups->value[$name]);
	}
}

?>