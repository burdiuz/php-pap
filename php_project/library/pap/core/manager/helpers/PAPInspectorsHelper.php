<?php

class PAPInspectorsHelper extends NonDynamicObject {
	/**
	 * 
	 * @var PAPConnectionsManager
	 */
	private $_manager;
	public function __construct(PAPConnectionsManager $manager){
		$this->_manager = $manager;
	}
	public function connected(IPAPConnectionInspector $inspector){
		$this->_manager->inspectors()->connectInspector($inspector);
	}
	public function disconnected(IPAPConnectionInspector $inspector){
		$this->_manager->inspectors()->disconnectInspector($inspector);
	}
	/**
	 * Current protocol used
	 * @return IPAPProtocolService
	 */
	public function protocol(){
		$this->_manager->protocol();
	}
	public function authorize(IPAPConnectionInspector $inspector, IPAPConnection $connection){
		
	}
	public function reportError(IPAPConnectionInspector $inspector, $id, PAPModuleCommand $command){
		
	}
}

?>