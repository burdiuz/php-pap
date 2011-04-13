<?php

class PropertyHandler extends Handler {
	protected $_name;
	protected $_ignoreArgumentCount;
	public function __construct($target, $name, $ignoreArgumentCount=false){
		parent::__construct($target);
		$this->_name = $name;
		$this->_ignoreArgumentCount = $ignoreArgumentCount;
	}
	public function call($arguments){
		$this->check($arguments);
		$this->setValue($arguments[0]);
	}
	public function apply(){
		$args = func_get_args();
		$this->check($args);
		$this->setValue($args[0]);
	}
	public function setValue($value){
		$name = $this->_name;
		$this->_target->$name = $value;
	}
	protected function check(&$array){
		if(!is_array($array)){
			throw new Exception('Argument must be an array.');
		}
		if(count($array)!=1 && !$this->_ignoreArgumentCount){
			throw new Exception('Arguments array must contain only one value.');
		}
	}
	public function __destruct(){
		parent::__destruct();
		unset($this->_name);
	}
}

?>