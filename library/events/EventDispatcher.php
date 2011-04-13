<?php

/*
 * 
 * 

$dispatcher = new EventDispatcher();
$dispatcher->addEventListener('evt', new FunctionHandler('mediumHandler'), 0);
$dispatcher->addEventListener('evt', new FunctionHandler('highHandler'), 50);
$dispatcher->addEventListener('evt', new FunctionHandler('lowHandler'), -100);
echo 'HAS '.$dispatcher->hasEventListener('evt').'<br>';
function lowHandler(Event $event){
	echo 'LOW '.$event.'<br>';
}
function mediumHandler(Event $event){
	echo 'MEDIUM '.$event.'<br>';
}
function highHandler(Event $event){
	echo 'HIGH '.$event.'<br>';
}
$dispatcher->dispatchEvent(new Event('evt'));
$dispatcher->removeEventListener('evt', new FunctionHandler('mediumHandler'));
$dispatcher->removeEventListener('evt', new FunctionHandler('highHandler'));
$dispatcher->addEventListener('evt', new FunctionHandler('highHandler'), 50);
save_log(' -------------------------- ');
$dispatcher->dispatchEvent(new Event('evt'));
echo 'HAS '.$dispatcher->hasEventListener('evt').'<br>';
$dispatcher->removeEventListener('evt', new FunctionHandler('lowHandler'));
$dispatcher->removeEventListener('evt', new FunctionHandler('mediumHandler'));
$dispatcher->removeEventListener('evt', new FunctionHandler('highHandler'));
echo 'HAS '.$dispatcher->hasEventListener('evt').'<br>';

 */
class EventDispatcher extends NonDynamicObject implements IEventDispatcher{
	private $_listeners = array();
	private $_sortings = array();
	/**
	 * Target IEventDispatcher instance
	 * @var IEventDispatcher
	 */
	private $_target;
	/**
	 * Target IEventDispatcher instance
	 * @var IEventDispatcher
	 */
	protected function setEventTarget(IEventDispatcher $target){
		$this->_target = $target;
	}
	/**
	 * Get real event target
	 * @return IEventDispatcher
	 */
	protected function getEventTarget(){
		return $this->_target ? $this->_target : $this;
	}
	public function addEventListener($eventType, IHandler $handler, $priority=0){
		$this->removeEventListener($eventType, $handler);
		$priorityHandlers = &$this->getHandlersList($eventType, (int)$priority);
		array_push($priorityHandlers, $handler);
		$this->_sortings[$eventType] = false;
	}
	public function removeEventListener($eventType, IHandler $handler){
		if(array_key_exists($eventType, $this->_listeners)){
			$eventHandlers = &$this->_listeners[$eventType];
			if(count($eventHandlers)){
				reset($eventHandlers);
				do{
					$priority = key($eventHandlers);
					$priorityHandlers = &$eventHandlers[$priority];
					while(($key = array_search($handler, $priorityHandlers))!==false){
						array_splice($priorityHandlers, $key, 1);
						if(!count($priorityHandlers)) unset($eventHandlers[$priority]);
						if(!count($eventHandlers)){
							unset($this->_listeners[$eventType]);
						}
						return true;
					}
				}while(next($eventHandlers)!==false);
			}
		}
		return false;
	}
	private function &getHandlersList($eventType, $priority){
		if(!array_key_exists($eventType, $this->_listeners))  $this->_listeners[$eventType] = array();
		$eventHandlers = &$this->_listeners[$eventType];
		if(!array_key_exists($priority, $eventHandlers))  $eventHandlers[$priority] = array();
		return $eventHandlers[$priority];
	}
	public function hasEventListener($eventType){
		return array_key_exists($eventType, $this->_listeners);
	}
	public function dispatchEvent(Event $event){
		$eventType = $event->type();
		if(array_key_exists($eventType, $this->_listeners)){
			/** @var Event */$event = $event->cloneEvent();
			$event->reset($this->getEventTarget());
			$eventHandlers = &$this->_listeners[$eventType];
			if(!$this->_sortings[$eventType]){
				ksort($eventHandlers);
				$this->_sortings[$eventType] = true;
			}
			end($eventHandlers);
			do{
				$priority = key($eventHandlers);
				$priorityHandlers = &$eventHandlers[$priority];
				foreach($priorityHandlers as $handler){
					if($event->isPropagationStopped()) return;
					$handler->apply($event);
				}
			}while(prev($eventHandlers)!==false);
			return true;
		}
		return false;
	}
	public function __toString(){
		return '[EventDispatcher(class="'.get_class($this).'", target="'.get_class($this->getEventTarget()).'", events="'.implode(', ', array_keys($this->_listeners)).'")]';
	}
	public function __destruct(){
		$this->_target = null;
		unset($this->_listeners);
	}
	/**
	 * 
	 * @param IEventDispatcher $target Set the real event target instance
	 */
	static public function create(IEventDispatcher $target=null){
		$instance = new EventDispatcher();
		$instance->setEventTarget($target);
		return $instance;
	}
}

?>