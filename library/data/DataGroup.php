<?php

class DataGroup extends NonDynamicObject implements IDataGroup{
	/**
	 * Current DataContainer instance
	 * @var IDataConainer
	 */
	private $_values;
	/**
	 * RAW groups data holder
	 * @var ValueHolder
	 */
	private $_groups;
	public function __construct($values=null){
		if($values instanceof DataContainer){
			$this->_values = $values;
		}else{
			$this->_values = new DataContainer($values);
		}
		$this->_groups = new ValueHolder(array());
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::value()
	 */
	public function value($name, $default=null){
		return $this->_values->value($name, $default);
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::hasValue()
	 */
	public function hasValue($name){
		return $this->_values->hasValue($name);
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::dataManager()
	 */
	public function dataManager(){
		return $this->_values->dataManager();
	}
	public function getIterator(){
		return $this->_values->getIterator();
	}
	public function dataIterator(){
		return $this->_values->dataIterator();
	}
	public function groupsIterator(){
		return new DataGroupsIterator($this->_groups);
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::values()
	 */
	public function values(){
		return $this->_values;
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::hasGroup()
	 */
	public function hasGroup($name){
		return isset($this->_groups->value[$name]) && $this->_groups->value[$name]->hasLevels();
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::group()
	 */
	public function group($name){
		return $this->_groups->value[$name];
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::groupManager()
	 */
	public function groupManager(){
		return new DataGroupManager($this->_groups);
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::groupByValue()
	 */
	public function groupByValue($name, $value){
		foreach($this->_groups->value as $levels){
			$item = $levels->levelByValue($name, $value);
			if($item) return $item;
		}
		return null;
	}
}

?>