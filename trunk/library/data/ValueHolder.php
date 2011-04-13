<?php

class ValueHolder extends NonDynamicObject {
	public $value;
	public function __construct($value=null){
		$this->value = $value;
	}
	public function hasValue(){
		return !is_null($this->value);
	}
	public function __destruct(){
		$this->value = null;
	}
}

?>