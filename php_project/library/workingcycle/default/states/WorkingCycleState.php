<?php

class WorkingCycleState extends NonDynamicObject implements IWorkingCycleState{
	private $_internal;
	public function __construct($index, $tick, $name='', $timeout=0, $enableEvents=true, $calculateLoad=true){
		$this->_internal = new WorkingCycleStateInternals($index, $tick, $name ? $name : (string)$index, $timeout, $enableEvents, $calculateLoad);
	}
	public function index(){
		return $this->_internal->index;
	}
	public function name(){
		return $this->_internal->name;
	}
	public function tick(){
		return $this->_internal->tick;
	}
	public function timeout(){
		return $this->_internal->timeout;
	}
	public function enableEvents(){
		return $this->_internal->enableEvents;
	}
	public function calculateLoad(){
		return $this->_internal->calculateLoad;
	}
	public function getInternal(){
		return $this->_internal;
	}
	/**
	 * @param IDataGroup $config
	 * @return PAPStateList
	 */
	static public function get($index, IDataGroup $config){
		return new WorkingCycleState(
			$index, 
			$config->value(WorkingCycleParameters::TICK, WorkingCycleParameters::DEFAULT_TICK)*1000, 
			$config->value(WorkingCycleParameters::NAME, (string)$index), 
			$config->value(WorkingCycleParameters::TIMEOUT, WorkingCycleParameters::DEFAULT_TIMEOUT), 
			$config->value(WorkingCycleParameters::ENABLE_EVENTS, WorkingCycleParameters::DEFAULT_ENABLE_EVENTS), 
			$config->value(WorkingCycleParameters::CALCULATE_LOAD, WorkingCycleParameters::DEFAULT_CALCULATE_LOAD)
		);
	}
	static public function getDefault(){
		return new WorkingCycleState(0, WorkingCycleParameters::DEFAULT_TICK, '', WorkingCycleParameters::DEFAULT_TIMEOUT);
	}
}

?>