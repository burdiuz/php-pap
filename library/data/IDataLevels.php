<?php

interface IDataLevels extends IDataGroup{
	/**
	 * Has group levels
	 * @return boolean
	 */
	public function hasLevels();
	/**
	 * If levels container has only one data group, it will allow to call group methods from levels instance
	 * @return boolean
	 */
	public function isSingleLevel();
	/**
	 * Return levels count, can be zero.
	 * @return int
	 */
	public function count();
	/**
	 * Return level
	 * @param int $index
	 * @return IDataContainer
	 */
	public function level($index);
	/**
	 * Get DataLevelsManager instance to manage current instance of IDataLevels
	 * @return IDataLevelsManager
	 */
	public function levelsManager();
	/**
	 * Get level by property name and value
	 * @param string $name
	 * @param any $value
	 * @return IDataContainer
	 */
	public function levelByValue($name, $value);
	/**
	 * Levels iterator
	 * @return Iterator
	 */
	public function levelsIterator();
}

?>