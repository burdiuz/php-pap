<?php

class VariableHandler extends Handler{
	protected $_name;
	protected $_ignoreArgumentCount;
	public function __construct($name, $ignoreArgumentCount=false){
		parent::__construct(null);
		$this->_name = $name;
		$this->_ignoreArgumentCount = $ignoreArgumentCount;
	}
	public function call($arguments){
		$this->check($arguments);
		$GLOBALS[$this->_name] = $arguments[0];
	}
	public function apply(){
		$args = func_get_args();
		$this->check($args);
		$GLOBALS[$this->_name] = $args[0];
	}
	public function setValue($value){
		$GLOBALS[$this->_name] = $value;
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