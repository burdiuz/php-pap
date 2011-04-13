<?php

/*
 * 
 * 

class Foo{
	public $property;
	public function show($target){
		echo $target;
	}
}
$obj = new Foo();
$phandler = new PropertyHandler($obj, 'property');
$phandler->apply('P.A.F. ');
echo $obj->property;
$mhandler = new MethodHandler($obj, 'show');
$mhandler->apply('THE ');
function show ($text){
	echo $text;
}
$fhandler = new FunctionHandler('show');
$fhandler->apply('BEST');
$variable = 'old value';
$vhandler = new VariableHandler('variable');
$vhandler->apply('!');
echo $variable;

 */
abstract class Handler extends NonDynamicObject implements IHandler{
	protected $_target;
	public function __construct($target){
		$this->_target = $target;
	}
	public function call($arguments){
		throw new Exception('Handler Error: Handler.call() method must be overridden');
	}
	public function apply(){
		throw new Exception('Handler Error: Handler.apply() method must be overridden');
	}
	public function caller(){
		return array($this, 'apply');
	}
	public function __destruct(){
		unset($this->_target);
	}
}

?>