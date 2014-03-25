<?php

class PAPInspectorsCollection extends PAPConnectionsManagerCollection{
	/**
	 * 
	 * @var ExecutableList
	 */
	private $_executables;
	public function __construct(){
		parent::__construct(false, true);
		$this->_executables = new ExecutableList(false, true);
	}
	/**
	 * 
	 * @param string $connectionType
	 * @return IPAPConnectionInspector[]
	 */
	public function getInspectors($connectionType){
		/** @var ExecutableList */$list = $this->getItems($connectionType);
		return $list ? $list->toArray() : array();
	}
	/**
	 * 
	 * @param string $connectionType
	 * @param IPAPConnectionInspector $inspector
	 */
	public function addInspector(IPAPConnectionInspector $inspector){
		$this->addNamedItem($inspector);
	}
	/**
	 * 
	 * @param string $connectionType
	 * @param IPAPConnectionInspector[] $list
	 */
	public function addInspectors($connectionType, $list){
		$this->addItems($connectionType, $list);
	}
	/**
	 * 
	 * @param string $connectionType
	 * @param IPAPConnectionInspector $inspector
	 */
	public function removeInspector(IPAPConnectionInspector $inspector){
		$this->removeNamedItem($inspector);
	}
	/**
	 * 
	 * @param string $connectionType
	 */
	public function removeInspectors($connectionType){
		$this->removeItems($connectionType);
	}
	/**
	 * Add inspector to executable list.
	 * @param IPAPConnectionInspector $inspector
	 * @return boolean
	 */
	public function connectInspector(IPAPConnectionInspector $inspector){
		if($this->isNamedItemExists($inspector)){
			$this->_executables->addItem($inspector);
			return true;
		}
		return false;
	}
	/**
	 * Remove inspector fromn executable list.
	 * @param IPAPConnectionInspector $inspector
	 * @return boolean
	 */
	public function disconnectInspector(IPAPConnectionInspector $inspector){
		return (boolean)$this->_executables->removeItem($inspector);
	}
	public function execute(){
		$this->_executables->execute();
	}
}

?>