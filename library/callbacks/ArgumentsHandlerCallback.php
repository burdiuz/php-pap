<?php

class ArgumentsHandlerCallback extends HandlerCallback {
	public function __callback(){
		/** @var array */
		$value = func_get_args();
		$this->_value = $value;
		$this->_handler->apply($value);
	}
}

?>