<?php

abstract class PAPConnectionInspector extends NonDynamicObject implements IPAPConnectionInspector {
	/**
	 * @var IPAPProtocolService
	 */
	private $_protocol;
	/**
	 * @var IPAPPublicConnectionManager
	 */
	private $_manager;
	/**
	 * @var boolean
	 */
	private $_connected;
	/**
	 * @var string
	 */
	private $_name;
	public function __construct($name, IPAPProtocolService $protocol, IPAPPublicConnectionManager $manager){
		$this->_name = $name;
		$this->_protocol = $protocol;
		$this->_manager = $manager;
	}
	public function name(){
		return $this->_name;
	}
	public function connect(){
		$this->_connected = true;
	}
	public function isConnected(){
		return $this->_connected;
	}
	public function close(){
		$this->_connected = false;
	}
}

?>