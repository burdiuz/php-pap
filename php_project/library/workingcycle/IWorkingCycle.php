<?php

interface IWorkingCycle extends IEventDispatcher{
	public function initialize(IHandler $handler, IEventDispatcher $target=null, WorkingCycleStateList $states=null);
	/**
	 * @return boolean
	 */
	public function isInitialized();
	/**
	 * Target EventDispatcher that will dispatch cycle specific events
	 * @return IEventDispatcher
	 */
	public function target();
	/**
	 * @return IWorkingCycleStateList
	 */
	public function states();
	public function start();
	public function stop();
	/**
	 * @return boolean
	 */
	public function isStarted();
	public function currentState();
	public function currentStateIndex();
	public function getCalculatedLoad();
	/**
	 * TRUE if current instance has a parent cycle
	 * @return boolean
	 */
	public function hasParent();
	/**
	 * Parent IWorkingCycle instance
	 * @return IWorkingCycle
	 */
	public function getParent();
	/**
	 * TRUE if current instance has children
	 * @return boolean
	 */
	public function hasChild();
	/**
	 * Get child IWorkingCycle instance, if no children this method will throw error
	 * @return IWorkingCycle
	 */
	public function getChild();
	/**
	 * Will create instance of IWorkingCycle and will place it atop of chain
	 * If current instance already has child, this method will throw error. 
	 * @param IHandler $handler If specified, instance will be started automatically
	 * @return IWorkingCycle
	 */
	public function createChild(IHandler $handler, IEventDispatcher $target=null, IWorkingCycleStateList $states=null);
	/**
	 * IWorkingCycleChain instance
	 * @return IWorkingCycleChain
	 */
	public function chain();
}

?>