<?php

abstract class HandlerCollection extends NonDynamicObject implements IHandler {
	protected $_items = array();
	public function getItemAt($index){
		return isset($this->_items[$index]) ? $this->_items[$index] : false;
	}
	public function getItemIndex(ICallable $item){
		return array_search($item, $this->_items, true);
	}
	public function items(){
		return $this->_items;
	}
	public function removeItem(ICallable $item){
		$index = $this->getItemIndex($item);
		if($index!==false){
			$this->removeItemAt($index);
		}
	}
	public function removeItemAt($index){
		array_splice($this->_items, $index, 1);
	}
	public function removeAll(){
		$this->_items = array();
	}
	public function call($arguments){
		throw new Exception('HandlerCollection Error: Method must be overriden.');
	}
	public function apply(){
		call_user_func_array(array($this, 'call'), func_get_args());
	}
	public function caller(){
		return array($this, 'apply');
	}
}

?>