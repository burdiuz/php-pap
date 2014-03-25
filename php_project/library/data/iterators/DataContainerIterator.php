<?php

class DataContainerIterator implements Iterator {
	private $_values;
	public function __construct(ValueHolder $values){
		$this->_values = $values;
	}
	public function current(){
		return current($this->_values->value);
	}
	public function next(){
		next($this->_values->value);
	}
	public function key(){
		return key($this->_values->value);
	}
	public function valid(){
		return (boolean)key($this->_values->value);
	}
	public function rewind(){
		reset($this->_values->value);
	}
}

?>