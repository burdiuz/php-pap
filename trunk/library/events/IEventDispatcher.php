<?php

interface IEventDispatcher {
	/**
	 * 
	 * @param string $eventType
	 * @param IHandler $handler
	 * @param int $priority
	 */
	public function addEventListener($eventType, IHandler $handler, $priority=0);
	/**
	 * 
	 * @param string $eventType
	 * @param IHandler $handler
	 * @return boolean
	 */
	public function removeEventListener($eventType, IHandler $handler);
	/**
	 * 
	 * @param string $eventType
	 * @return boolean
	 */
	public function hasEventListener($eventType);
	/**
	 * 
	 * @param Event $event
	 * @return boolean
	 */
	public function dispatchEvent(Event $event);
}
?>