<?php

interface IDataContainerManager{
	/**
	 * Returns value by it's name and group name
	 * @param string $name
	 * @param $default
	 */
	public function get($name);
	/**
	 * Set value by it's name.
	 * @param string $name
	 * @param $value
	 */
	public function set($name, $value);
	/**
	 * Set values from list by it's indexes as names.
	 * @param array $values
	 */
	public function setList($values);
	/**
	 * Check is there are 
	 * @param string $name
	 * @return boolean
	 */
	public function has($name);
	/**
	 * Delete value by name
	 * @param string $name
	 */
	public function remove($name);
}

?>