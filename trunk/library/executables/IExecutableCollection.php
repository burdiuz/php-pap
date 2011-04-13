<?php

/**
 * Basic interface for collections of IExecutable instances. 
 * @author iFrame
 * @see IExecutableList
 * @see IExecutableHash
 */
interface IExecutableCollection extends IExecutable, IteratorAggregate{
	/**
	 * From IExecutable instance from collection
	 * @param IExecutable $item Item to remove
	 * @retrun any May return a key that was assigned to removed item
	 */
	public function removeItem(IExecutable $item);
	/**
	 * Was item added to this collection
	 * @param IExecutable $item
	 * @return boolean
	 */
	public function hasItem(IExecutable $item);
	/**
	 * Array of IExecutable items of this collection
	 * @return array
	 */
	public function toArray();
	/**
	 * Items count in collection
	 * @retrun int 
	 */
	public function count();
}

?>