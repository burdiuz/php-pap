<?php

class MultiHandlerHolder extends NonDynamicObject implements IMultiHandlerHolder {
	private $_handlers = array();
	public function getHandlers($action){
		return $this->isHandlerExists($action) ? $this->_handlers[$action] : array();
	}
	public function addHandler($action, IHandler $handler){
		if($handler){
			if($this->isHandlerExists($action)){
				if(in_array($handler, $this->_handlers[$action], true)){
					throw new Exception('MultiHandlerHolder Error: This handler already registered for "'.$action.'" action.');
				}else{
					array_push($this->_handlers[$action], $handler);
				}
			}else{
				$this->_handlers[$action] = array($handler);
			}
		}
	}
	public function callHandlers($action, $data){
		$handlers = $this->getHandlers($action);
		$value = false;
		foreach($handlers as /** @var IHandler */$handler){
			$handler->apply($data);
			$value = true;
		}
		return $value;
	}
	public function countHandlers($action){
		return isset($this->_handlers[$action]) ? count($this->_handlers[$action]) : 0;
	}
	public function removeHandler($action, IHandler $handler){
		if($this->countHandlers($action)>0){
			$list = $this->_handlers[$action];
			$index = array_search($handler, $this->_handlers[$action], true);
			if($index!==false){
				array_splice($this->_handlers[$action], $index, 1);
				return true;
			}
		}
		return false;
	}
	public function removeHandlers($action){
		unset($this->_handlers[$action]);
	}
	public function removeAllHandlers(){
		$this->_handlers = array();
	}
	public function __destruct(){
		$this->removeAllHandlers();
	}
}

?>