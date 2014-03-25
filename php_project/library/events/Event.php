<?php

class Event extends NonDynamicObject{
	private $_type;
	private $_cancelable;
	/**
	 * Target IEventDispatcher instance
	 * @var IEventDispatcher
	 */
	private $_target;
	private $_prevented;
	private $_stopped;
	public function __construct($type, $cancelable=false){
		$this->_type = $type;
		$this->_cancelable = $cancelable;
	}
	public function reset(IEventDispatcher $target=null){
		$this->_target = $target;
		$this->_prevented = false;
		$this->_stopped = false;
	}
	public function type(){
		return $this->_type;
	}
	public function cancelable(){
		return $this->_cancelable;
	}
	public function target(){
		return $this->_target;
	}
	public function isDefaultPrevented(){
		return $this->_prevented;
	}
	public function preventDefault(){
		if($this->_cancelable){
			$this->_prevented = true;
		}
	}
	public function cloneEvent(){
		return clone $this;
	}
	public function stopPropagation(){
		$this->_stopped = true;
	}
	public function isPropagationStopped(){
		return $this->_stopped;
	}
	public function __clone(){
		$this->reset(null);
	}
	public function __toString(){
		return $this->formatString(array('type'=>'_type', 'cancelable'=>'_cancelable', 'prevented'=>'_prevented'));
	}
	public function __destruct(){
		unset($this->_target);
	}
}

?>