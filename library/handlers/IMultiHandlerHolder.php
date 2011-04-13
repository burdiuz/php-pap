<?php

interface IMultiHandlerHolder{
	public function getHandlers($action);
	public function addHandler($action, IHandler $handler);
	public function callHandlers($action, $data);
	public function countHandlers($action);
	public function removeHandler($action, IHandler $handler);
	public function removeHandlers($action);
	public function removeAllHandlers();
}

?>