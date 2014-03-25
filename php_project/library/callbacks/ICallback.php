<?php

interface ICallback extends ICallable{
	/**
	 * Return saved data from called method
	 * @return any
	 */
	public function getData();
}

?>