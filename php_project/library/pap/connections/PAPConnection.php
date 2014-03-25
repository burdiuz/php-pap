<?php

abstract class PAPConnection extends HandlerHolder implements IPAPConnection {
	protected $_id;
	protected $_name;
	protected $_moduleLevel;
	protected $_trustLevel;
	protected $_connected;
	protected $_sentEntities = array();
	public function __construct($id, $name, $moduleLevel, $trustLevel){
		
	}
	public function id(){
		return $this->_id;
	}
	public function name(){
		return $this->_name;
	}
	public function moduleLevel(){
		return $this->_moduleLevel;
	}
	public function trustLevel(){
		return $this->_trustLevel;
	}
	public function connect(){
		
	}
	public function isConnected(){
		return $this->_connected;
	}
	public function close(){
		
	}
	public function send(IPAPProtocolEntity $entity){
		if($entity){
			array_push($this->_sentEntities, $entity);
		}
	}
	public function read(){
		
	}
	public function write(){
		
	}
	public function writeEntity(IPAPProtocolEntity $entity){
		
	}
	public function execute(){
		$this->read();
		$this->write();
	}
}

?>