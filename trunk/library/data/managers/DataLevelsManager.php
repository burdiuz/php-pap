<?php

class DataLevelsManager extends NonDynamicObject implements IDataLevelsManager {
	private $_levels;
	public function __construct(DataLevels $levels){
		$this->_levels = $levels;
	}
	public function get($index){
		return $this->_levels->offsetGet($index);
	}
	public function has($index){
		return $this->_levels->offsetExists($index);
	}
	public function add(IDataContainer $group){
		$this->_levels->append($group);
	}
	public function set($index, IDataContainer $group){
		$this->_levels->offsetSet($index, $group);
	}
	public function remove($index){
		$this->_levels->offsetUnset($index);
	}
	public function count(){
		return $this->_levels->count();
	}
}

?>