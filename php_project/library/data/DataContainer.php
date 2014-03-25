<?php

class DataContainer implements IDataContainer{
	private $_values;
	public function __construct($values=null){
		$this->_values = new ValueHolder(is_array($values) ? $values : array());
	}
	public function __get($name){
		return $this->_values->value[$name];
	}
	public function __isset($name){
		return isset($this->_values->value[$name]);
	}
	public function __set($name, $value){
		throw new Exception('DataContainer Eror: To change values you should use DataContainerManager.');
	}
	public function __unset($name){
		throw new Exception('DataContainer Eror: To unset values you should use DataContainerManager.');
	}
	public function getIterator(){
		return $this->dataIterator();
	}
	public function dataIterator(){
		return new DataContainerIterator($this->_values);
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::value()
	 */
	public function value($name, $default=null){
		return $this->__isset($name) ? $this->__get($name) : $default;
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::hasValue()
	 */
	public function hasValue($name){
		return $this->__isset($name);
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::dataManager()
	 */
	public function dataManager(){
		return new DataContainerManager($this->_values);
	}
}

?>