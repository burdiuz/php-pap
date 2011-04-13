<?php

class HandlerQueue extends HandlerCollection{
	public function addItem(ICallable $item){
		array_push($this->_items, $item);
	}
	public function call($arguments){
		foreach($this->_items as /** @var ICallable */ $handler){
			$handler->call($arguments);
		}
	}
}

?>