<?php

class WorkingCycleEvent extends Event {
	/**
	 * Tick execution started
	 * @var string
	 */
	const TICK_ENTER = 'tickEnter';
	/**
	 * Tick execution stopped
	 * @var string
	 */
	const TICK_EXIT = 'tickExit';
	/**
	 * State changed
	 * @var string
	 */
	const STATE_CHANGED = 'stateChanged';
	/**
	 * 
	 * @var IWorkingCycleState
	 */
	private $_state;
	public function __construct($type, $cancelable=false, IWorkingCycleState $state=null){
		parent::__construct($type, $cancelable);
		$this->_state = $state;
	}
	/**
	 * 
	 * @return IWorkingCycleState
	 */
	public function state(){
		return $this->_state;
	}
}

?>