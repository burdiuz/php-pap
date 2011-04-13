<?php

/**
 * Indexed collection of IExecutable instances
 * @author iFrame
 *
 */
interface IExecutableList extends IExecutableCollection{
	/**
	 * Add IExecutable instance to collection
	 * @param IExecutable $item Item to add
	 * @retrun any May return a key assigned to added item
	 */
	public function addItem(IExecutable $item);
	/**
	 * Add IExecutable instance to list using specific index
	 * @param int $index
	 * @param IExecutable $item
	 */
	public function addItemTo($index, IExecutable $item);
	/**
	 * Get collection item by index
	 * @param int $index Index of collection item
	 * @return IExecutable|FALSE
	 */
	public function getItemAt($index);
	/**
	 * Remove item from collection by index
	 * @param int $index Index of collection item
	 * @return IExecutable|FALSE
	 */
	public function removeItemAt($index);
	/**
	 * Get index of element if it was added to collection before, if not, will return -1.
	 * @param IExecutable $item
	 * @return int|FALSE
	 */
	public function indexOf(IExecutable $item);
}

?>