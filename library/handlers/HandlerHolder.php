<?php

class HandlerHolder extends NonDynamicObject implements IHandlerHolder {
	private $_handlers = array();
	/* (non-PHPdoc)
	 * @see IHandlerHolder::setHandler()
	 */
	public function setHandler($action, IHandler $handler){
		if($this->isHandlerExists($action)){
			throw new Exception('HandlerHolder Error: Handler for "'.$action.'" already set.');
		}else if(!$handler){
			throw new Exception('HandlerHolder Error: To remove handler use HandlerHolder/removeHandler().');
		}else{
			$this->_handlers[$action] = $handler;
		}
	}
	/* (non-PHPdoc)
	 * @see IHandlerHolder::removeHandler()
	 */
	public function removeHandler($action){
		unset($this->_handlers[$action]);
	}
	/* (non-PHPdoc)
	 * @see IHandlerHolder::isHandlerExists()
	 */
	public function isHandlerExists($action){
		return isset($this->_handlers[$action]);
	}
	/* (non-PHPdoc)
	 * @see IHandlerHolder::getHandler()
	 */
	public function getHandler($action){
		return $this->isHandlerExists($action) ? $this->_handlers[$action] : null;
	}
	/* (non-PHPdoc)
	 * @see IHandlerHolder::callHandler()
	 */
	public function callHandler($action, $data){
		if($this->isHandlerExists($action)){
			/** @var IHandler */$handler = $this->_handlers[$action];
			$handler->apply($data);
			return true;
		}
		return false;
	}
	/* (non-PHPdoc)
	 * @see IHandlerHolder::resetHandler()
	 */
	public function resetHandler($action, IHandler $handler){
		if($handler){
			$this->_handlers[$action] = $handler;
		}else{
			throw new Exception('HandlerHolder Error: To remove handler use HandlerHolder/removeHandler().');
		}
	}
	/* (non-PHPdoc)
	 * @see IHandlerHolder::removeAllHandlers()
	 */
	public function removeAllHandlers(){
		$this->_handlers = array();
	}
	public function __destruct(){
		$this->removeAllHandlers();
	}
}

?>