<?php
class DataContainerManager extends NonDynamicObject implements IDataContainerManager {
	/**
	 * RAW values holder
	 * @var ValueHolder
	 */
	private $_values;
	public function __construct(ValueHolder $values){
		$this->_values = $values;
	}
	public function get($name){
		return $this->_values->value[$name];
	}
	public function set($name, $value){
		$this->_values->value[$name] = $value;
	}
	public function setList($values){
		if(is_array($values)){
			foreach($values as $name=>$value){
				$this->_values->value[$name] = $value;
			}
		}
	}
	public function has($name){
		return isset($this->_values->value[$name]);
	}
	public function remove($name){
		unset($this->_values->value[$name]);
	}
}

?>