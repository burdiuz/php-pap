<?php

class PAPSocketConnectionFactory extends NonDynamicObject implements IPAPConnectionFactory {
	/**
	 * Connections creation config
	 * @var PAPSocketConnectionConfig
	 */
	private $_config;
	public function __construct(IDataGroup $config=null){
		$this->_config = new PAPSocketConnectionConfig($config);
	}
	public function name(){
		return $this->_config->name;
	}
	public function getInspector(PAPInspectorsHelper $helper){
		return new PAPSocketConnectionInspector($helper, $this->_config);
	}
	public function getConnection(IPAPConnectionsHelper $helper){
		return array();
	}
	public function getLauncher(PAPLaunchersHelper $helper){
		return new PAPSocketLauncher($helper, $this->_config);
	}
	public function getCoreLauncher(){
		return null;
	}
	public function isSupported(){
		return function_exists('socket_create');
	}
	public function __destruct(){
		$this->_protocol = null;
		$this->_config = null;
		$this->_manager = null;
	}
	static public function getInstance(IDataGroup $config=null){
		return new PAPSocketConnectionFactory($config);
	}

}

?>