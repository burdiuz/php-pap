<?php

class ArgumentsQueueCallback extends QueueCallback {
	public function getData(){
		return $this->_queue;
	}
	public function __callback(){
		array_push($this->_queue, func_get_args());
	}
}

?>