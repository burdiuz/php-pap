<?php

class PAPSocketConnectionInspector extends NonDynamicObject implements IPAPConnectionInspector{
	/**
	 * @var IPAPProtocolService
	 */
	private $_protocol;
	/**
	 * @var PAPSocketConnectionConfig
	 */
	private $_config;
	/**
	 * @var PAPInspectorsHelper
	 */
	private $_helper;
	/**
	 * @var boolean
	 */
	private $_connected;
	public function __construct(PAPInspectorsHelper $helper, PAPSocketConnectionConfig $config){
		$this->_helper = $helper;
		$this->_protocol = $helper->protocol();
		$this->_config = $config;
	}
	public function name(){
		return $this->_config->name;
	}
	public function connect(){
		
	}
	public function isConnected(){
		return $this->_connected;
	}
	public function close(){
		
	}
	public function read(){
		
	}
	public function execute(){
		if($this->_connected){
			$this->read();
		}
	}
	public function __destruct(){
		if($this->isConnected()){
			$this->close();
		}
	}
}

?>