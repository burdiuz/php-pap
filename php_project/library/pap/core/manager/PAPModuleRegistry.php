<?php

/**
 * Contains IDs of launched but not connected yet modules that awaiting for trusted connection.
 * @author iFrame
 *
 */
final class PAPModuleRegistry extends NonDynamicObject{
	private $_list = array();
	public function add($id, IDataGroup $config=null, $name='', $level=-1){
		if(!$id || array_key_exists($id, $this->_list)) return false;
		$this->_list[$id] = new PAPRegisteredModule($id, $config, $name, $level);
		return true;
	}
	/**
	 * 
	 * @param PAPRegisteredModule $module
	 * @return boolean
	 */
	public function addModule(PAPRegisteredModule $module){
		$id = $module->id();
		if(!$id || array_key_exists($id, $this->_list)) return false;
		$this->_list[$id] = $module;
		return true;
	}
	/**
	 * Is module ID registered
	 * @param string $id
	 * @return boolean
	 */
	public function isExists($id){
		return array_key_exists($id, $this->_list);
	}
	/**
	 * Get info about launched module
	 * @param string $id
	 * @return PAPRegisteredModule
	 */
	public function get($id){
		return isset($this->_list[$id]) ? $this->_list[$id] : false;
	}
	/**
	 * Remove module ID from registered
	 * @param string $id
	 */
	public function remove($id){
		unset($this->_list[$id]);
	}
	public function __destruct(){
		$this->_list = null;
	}
}

?>