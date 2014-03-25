<?php

interface IWorkingCycleState {
	/**
	 * State index in list
	 * @return int
	 */
	public function index();
	/**
	 * State name
	 * @return string
	 */
	public function name();
	/**
	 * State tick delay
	 * @return int
	 */
	public function tick();
	/**
	 * State timeout, in which state can be changed
	 * @return int
	 */
	public function timeout();
	/**
	 * If TRUE, will dispatch events
	 * @return boolean
	 */
	public function enableEvents();
	/**
	 * If TRUE, will calculate load percentage(execution_time/tick)
	 * @return boolean
	 */
	public function calculateLoad();
}

?>