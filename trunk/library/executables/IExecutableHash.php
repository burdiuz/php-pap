<?php

/**
 * Collection of IExecutable instances that uses string keys to store items.
 * @author iFrame
 *
 */
interface IExecutableHash extends IExecutableCollection{
	/**
	 * Add IExecutable instance to list using specific key
	 * @param string $key
	 * @param IExecutable $item
	 */
	public function addItemByKey($key, IExecutable $item);
	/**
	 * Get collection item by key
	 * @param string $key String key of collection item
	 * @return IExecutable|FALSE
	 */
	public function getItemByKey($key);
	/**
	 * Remove item from collection by key
	 * @param string $key String key of collection item
	 * @return IExecutable|FALSE
	 */
	public function removeItemByKey($key);
	/**
	 * Get index of element if it was added to collection before, if not, will return null.
	 * @param IExecutable $item
	 * @return string|FALSE
	 */
	public function getKey(IExecutable $item);
	/**
	 * Was this key specified for this hash object
	 * @param string $key
	 * @return boolean
	 */
	public function hasKey($key);
}

?>