<?php

/**
 * Диспатчит ValueEvent, когда приходит новое значение/ия

$callback = new ArgumentsEventCallback();
$callback->addEventListener(ValueEvent::VALUE_COMMIT, new FunctionHandler('handler'));
function handler(ValueEvent $event){
	echo print_r($event->value());
}
call_user_func($callback->caller(), 'value1', 'value2', 'value3');

 * @author Oleg
 *
 */
class ArgumentsEventCallback extends AbstractEventCallback {
	protected $_value;
	public function getData(){
		return $this->_value;
	}
	public function __callback(){
		$this->_value = $value;
		$this->_dispatcher->dispatchEvent(new ValueEvent(ValueEvent::VALUE_COMMIT, false, func_get_args()));
	}
}

?>