<?php

interface IWorkingCycleChain {
	/**
	 * Get first(root) IWorkingCycle instance
	 * @return IWorkingCycle
	 */
	public function getFirst();
	/**
	 * Get IWorkingCycle instance by its index in chain
	 * @param int $index
	 * @return IWorkingCycle
	 */
	public function getAt($index);
	/**
	 * Count of cycles in chain
	 * @return int
	 */
	public function count();
	/**
	 * Get last(leaf) IWorkingCycle instance. Only leaf instance is active, others will wait for it execution.
	 * @return IWorkingCycle
	 */
	public function getLast();

	
}

?>