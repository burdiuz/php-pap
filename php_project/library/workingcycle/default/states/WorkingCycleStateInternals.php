<?php

class WorkingCycleStateInternals {
	public $index;
	public $name;
	public $tick;
	public $timeout;
	public $enableEvents;
	public $calculateLoad;
	public function __construct($index, $tick, $name, $timeout, $enableEvents, $calculateLoad){
		$this->index = $index;
		$this->tick = $tick;
		$this->name = $name;
		$this->timeout = $timeout;
		$this->enableEvents = $enableEvents;
		$this->calculateLoad = $calculateLoad;
	}
}

?>