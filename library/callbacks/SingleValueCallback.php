<?php

class SingleValueCallback extends AbstractCallback {
	public $value;
	public function __construct(){
		parent::__construct();
	}
	public function getData(){
		return $this->value;
	}
	public function __callback($value){
		$this->value = $value;
	}
}

?>