<?php

class ValueEvent extends Event {
	const VALUE_COMMIT = 'valueCommit';
	protected $_value;
	public function __construct($type, $cancelable=false, $value=null){
		parent::__construct($type, $cancelable);
		$this->_value = $value;
	}
	public function value(){
		return $this->_value;
	}
}

?>