<?php

class PAPConnectionsManagerHelpers extends NonDynamicObject {
	protected $_inspector;
	protected $_launcher;
	protected $_connection;
	public function __construct(PAPConnectionsManager $manager){
		$this->_inspector = new PAPInspectorsHelper($manager);
		$this->_launcher = new PAPLaunchersHelper($manager);
		$this->_connection = new PAPCoreConnectionsHelper($manager);
	}
	public function inspector(){
		return $this->_inspector;
	}
	public function launcher(){
		return $this->_launcher;
	}
	public function connection(){
		return $this->_connection;
	}
}

?>