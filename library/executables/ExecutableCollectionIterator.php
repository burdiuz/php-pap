<?php

class ExecutableCollectionIterator implements Iterator {
	private $_items;
	public function __construct(ValueHolder $items){
		$this->_items = $items;
	}
	public function current(){
		return current($this->_items->value);
	}
	public function next(){
		next($this->_items->value);
	}
	public function key(){
		return key($this->_items->value);
	}
	public function valid(){
		return (boolean)key($this->_items->value);
	}
	public function rewind(){
		reset($this->_items->value);
	}
}

?>