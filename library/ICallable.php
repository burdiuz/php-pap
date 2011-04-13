<?php

interface ICallable {
	/**
	 * Execute ICallable instance with arguments list passed
	 * @param array $arguments list of arguments
	 */
	public function call($arguments);
	/**
	 * Execute ICallable instance with arguments that was passed to this method
	 */
	public function apply();
	/**
	 * Callback array for call_user_func() and call_user_func_array() functions.
	 * @return array
	 */
	public function caller();
}

?>