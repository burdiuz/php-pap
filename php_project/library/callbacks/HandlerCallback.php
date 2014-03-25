<?php

class HandlerCallback extends AbstractCallback {
	/**
	 * @var IHandler
	 */
	protected $_handler;
	protected $_value;
	public function __construct(IHandler $handler){
		parent::__construct();
		if($handler){
			$this->_handler = $handler;
		}else{
			throw new Exception('HandlerCallback Error: Requires IHandler instance specified.');
		}
	}
	public function getData(){
		return $this->_value;
	}
	public function __callback($value){
		$this->_value = $value;
		$this->_handler->apply($value);
	}
}

?>