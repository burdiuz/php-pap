<?php

/**
 * Config parameters and sub-groups that allowed in Working Cycle satates config group
 * @see PAPWorkingCycle
 * @author iFrame
 *
 */
class WorkingCycleParameters {
	private function __construct(){
		
	}
	/**
	 * Core working cycle timeouts
	 * @see PAPStatesConfig
	 * @var string
	 */
	const GROUP_STATES = 'states';
	/**
	 * Group that describe a single state
	 * @var string
	 */
	const GROUP_STATE = 'state';
	/**
	 * State name, optional parameter. If name not specified, state index will be also it's name.
	 * @var string
	 */
	const NAME = 'name';
	/**
	 * Working Cycle tick interval in milliseconds for state, wehere it was defined
	 * @var string
	 */
	const TICK = 'tick';
	/**
	 * Activity timeout for state where it was defined, on timeout Working Cycle will check and switch to next defined state.
	 * @var string
	 */
	const TIMEOUT = 'timeout';
	const ENABLE_EVENTS = 'enableEvents';
	const CALCULATE_LOAD = 'calculateLoad';
	/**
	 * Default state tick for working cycle, in milliseconds.
	 * @var float
	 */
	const DEFAULT_TICK = 100;
	/**
	 * Default state timeout for working cycle, in seconds. Zero value means that timeout disabled by default.
	 * @var float
	 */
	const DEFAULT_TIMEOUT = 0;
	const DEFAULT_ENABLE_EVENTS = true; 
	const DEFAULT_CALCULATE_LOAD = true;
}

?>