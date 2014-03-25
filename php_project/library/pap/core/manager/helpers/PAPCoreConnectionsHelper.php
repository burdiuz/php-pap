<?php

final class PAPCoreConnectionsHelper extends NonDynamicObject implements IPAPConnectionsHelper {
	/**
	 * 
	 * @var PAPConnectionsManager
	 */
	private $_manager;
	public function __construct(PAPConnectionsManager $manager){
		$this->_manager = $manager;
	}
	public function connected(IPAPConnection $connection){
		
	}
	public function disconnected(IPAPConnection $connection){
		
	}
	/**
	 * Current protocol used
	 * @return IPAPProtocolService
	 */
	public function protocol(){
		$this->_manager->protocol();
	}
	public function send(IPAPConnection $connection, PAPProtocolTransport $message){
		
	}
	public function reportError(IPAPConnection $connection, $id, Exception $error){
		
	}
}

?>