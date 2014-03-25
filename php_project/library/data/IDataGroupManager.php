<?php

interface IDataGroupManager {
	/**
	 * Get config group as new config object
	 * @param string $name
	 * @return IDataLevels
	 */
	public function get($name);
	/**
	 * Check is group exists
	 * @param string $name
	 * @return boolean
	 */
	public function has($name);
	/**
	 * Adds a new level into this group.
	 * @param string $name
	 * @param IDataContainer $group
	 */
	public function add($name, IDataContainer $group);
	/**
	 * Sets a new child group for this name in this group 
	 * @param string $name
	 * @param IDataContainer $group
	 */
	public function set($name, IDataContainer $group);
	/**
	 * Removes group
	 * @param string $name
	 */
	public function remove($name);
}

?>