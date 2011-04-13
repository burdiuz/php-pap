<?php

interface IDataContainer extends IteratorAggregate{
	/**
	 * Returns value by it's name and group name
	 * @param string $name
	 * @param $default
	 */
	public function value($name, $default=null);
	/**
	 * Check is there are 
	 * @param string $name
	 * @return boolean
	 */
	public function hasValue($name);
	/**
	 * Get IDataContainerManager instance to manage current data
	 * @return IDataContainerManager
	 */
	public function dataManager();
	/**
	 * Data iterator
	 * @return Iterator
	 */
	public function dataIterator();
}

?>