<?php
interface IDataGroup extends IDataContainer{
	
	/**
	 * Returns IDataContainer instance with values of current group
	 * @return IDataContainer
	 */
	public function values();
	/**
	 * Get config group as new config object
	 * @param string $name
	 * @return IDataLevels
	 */
	public function group($name);
	/**
	 * Check is group exists
	 * @param string $name
	 * @return boolean
	 */
	public function hasGroup($name);
	/**
	 * Get IDataGroupManager instance to manage groups
	 * @return IDataGroupManager
	 */
	public function groupManager();
	/**
	 * Get child group where property $name contains value equal to $value
	 * @param string $name Property name
	 * @param any $value Value
	 */
	public function groupByValue($name, $value);
	/**
	 * Groups iterator
	 * @return Iterator
	 */
	public function groupsIterator();
}

?>