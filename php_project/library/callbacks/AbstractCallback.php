<?php

abstract class AbstractCallback extends NonDynamicObject implements ICallback{
	const CALLBACK = '__callback';
	protected $_callbackName;
	public function __construct($callback=self::CALLBACK){
		$this->_callbackName = $callback;
	}
	public function getData(){
		throw new Exception('AbstractCallback Error: AbstractCallback.getData() must be overridden.');
	}
	public function caller(){
		return array($this, $this->_callbackName);
	}
	public function call($arguments){
		return call_user_func_array($this->_caller, $arguments);
	}
	public function apply(){
		return call_user_func_array($this->_caller, func_get_args());
	}
}

?>