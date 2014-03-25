<?php

interface IHandlerHolder {
	/**
	 * Sets handler for specified action 
	 * @param string $action
	 * @param IHandler $handler
	 */
	public function setHandler($action, IHandler $handler);
	/**
	 * Removes handler for specified action
	 * @param string $action
	 */
	public function removeHandler($action);
	/**
	 * Check is there are set handler
	 * @param string $action
	 * @return boolean
	 */
	public function isHandlerExists($action);
	/**
	 * Returns handler for action if it was set before
	 * @param string $action
	 * @return IHandler
	 */
	public function getHandler($action);
	/**
	 * Calls handler for action passing data into call method
	 * @param string $action
	 * @param $data
	 */
	public function callHandler($action, $data);
	/**
	 * Resets handler for action, removing previous handler if it exists 
	 * @param string $action
	 * @param IHandler $handler
	 */
	public function resetHandler($action, IHandler $handler);
	/**
	 * Remove all handlers for all actions
	 */
	public function removeAllHandlers();
}

?>