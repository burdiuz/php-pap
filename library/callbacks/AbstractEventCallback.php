<?php

/**
 * Диспатчит ValueEvent, когда приходит новое значение/ия
 * @author Oleg
 *
 */
abstract class AbstractEventCallback extends AbstractCallback implements IEventDispatcher{
	/**
	 * 
	 * @var IEventDispatcher
	 */
	protected $_dispatcher;
	public function __construct(IEventDispatcher $dispatcher=null){
		parent::__construct();
		$this->_dispatcher = $dispatcher ? $dispatcher : EventDispatcher::create($this);
	}
	public function addEventListener($eventType, IHandler $handler, $priority=0){
		$this->_dispatcher->addEventListener($eventType, $handler, $priority);
	}
	public function removeEventListener($eventType, IHandler $handler){
		return $this->_dispatcher->removeEventListener($eventType, $handler);
	}
	public function hasEventListener($eventType){
		return $this->_dispatcher->hasEventListener($eventType);
	}
	public function dispatchEvent(Event $event){
		return $this->_dispatcher->dispatchEvent($event);
	}
}

?>