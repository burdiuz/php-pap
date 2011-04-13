<?php

class FunctionHandler extends VariableHandler implements IMultiValueHandler{
	public function __construct($name){
		parent::__construct($name);
	}
	public function call($arguments){
		call_user_func_array($this->_name, $arguments);
	}
	public function apply(){
		$args = func_get_args();
		call_user_func_array($this->_name, $args);
	}
}

?>