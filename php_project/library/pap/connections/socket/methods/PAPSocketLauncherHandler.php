<?php

final class PAPSocketLauncherHandler extends NonDynamicObject {
	/**
	 * @var string
	 */
	public $id = '';
	/**
	 * @var PAPModuleCommand
	 */
	public $command = '';
	/**
	 * @var resource
	 */
	public $handler = null;
	/**
	 * Anything else you want to store with this handler
	 * @var any
	 */
	public $options = null;
	/**
	 * @var string
	 */
	public $output = '';
	/**
	 * 
	 * @var number
	 */
	public $timeout = 0;
	/**
	 * 
	 * @var boolean
	 */
	public $finished = false;
	public function __construct($id, PAPModuleCommand $command, $handler, $options=null){
		$this->id = $id;
		$this->command = $command;
		$this->handler = $handler;
		$this->options = $options;
	}
	/**
	 * 
	 * @return boolean
	 */
	public function hasOutput(){
		return strlen($this->output);
	}
	public function appendOutput($string){
		$this->output .= $string;
	}
	/**
	 * 
	 * @return boolean
	 */
	public function isFinished(){
		return $this->finished;
	}
	public function updateTimeout(){
		$this->timeout = microtime(true);
	}
	public function isTimedOut($maximumDelay){
		return microtime(true)-$this->timeout>$maximumDelay;
	}
	public function setFinished(){
		$this->finished = true;
	}
	/**
	 * 
	 * @return boolean
	 */
	public function hasHandler(){
		return $this->handler && is_resource($this->handler);
	}
}

?>