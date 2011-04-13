<?php

interface IDataLevelsManager{
	/**
	 * Return level
	 * @param int $index
	 * @return IDataContainer
	 */
	public function get($index);
	/**
	 * Has level
	 * @param boolean $index
	 * @return boolean
	 */
	public function has($index);
	/**
	 * Push IDataContainer as new level of the group
	 * @param IDataContainer $group
	 */
	public function add(IDataContainer $group);
	/**
	 * Reset level by index
	 * @param int $index
	 * @param IDataContainer $group
	 */
	public function set($index, IDataContainer $group);
	/**
	 * Remove level from index
	 * @param int $index
	 */
	public function remove($index);
	/**
	 * Return levels count
	 * @return int
	 */
	public function count();
}
?>