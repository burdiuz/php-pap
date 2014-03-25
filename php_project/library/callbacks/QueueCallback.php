<?php

class QueueCallback extends AbstractCallback {
	protected $_queue;
	public function __construct(){
		parent::__construct();
		$this->clean();
	}
	public function queue(){
		return $this->_queue;
	}
	public function getData(){
		return $this->_queue;
	}
	public function clean(){
		$this->_queue = array();
	}
	public function __callback($value){
		array_push($this->_queue, $value);
	}
}

?>