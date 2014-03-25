<?php

final class PAPRegisteredModule extends NonDynamicObject {
	private $_id;
	private $_config;
	private $_name;
	private $_level;
	public function __construct($id, IDataGroup $config=null, $name='', $level=-1){
		$this->_id = $id;
		$this->_config = $config;
		$this->_name = $name;
		$this->_level = $level;
	}
	/**
	 * Has module delayed configuration
	 * @return boolean
	 */
	public function hasConfig(){
		return (boolean)$this->_config;
	}
	/**
	 * Is module name specified
	 * @param string $id
	 * @return boolean
	 */
	public function isNameSpecified(){
		return (boolean)$this->_name;
	}
	/**
	 * Is module level specified
	 * @param string $id
	 * @return boolean
	 */
	public function isLevelSpecified(){
		return $this->_level>=0;
	}
	/**
	 * Module instance unique ID
	 * @return string
	 */
	public function id(){
		return $this->_id;
	}
	/**
	 * Get module configuration
	 * @return IDataGroup
	 */
	public function config(){
		return $this->_config;
	}
	/**
	 * Get module name
	 * @return string
	 */
	public function name(){
		return $this->_name;
	}
	/**
	 * Get module level
	 * @return int
	 */
	public function level(){
		return $this->_level;
	}
}

?>