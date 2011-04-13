<?php

interface INamedEntity {
	/**
	 * Name string, for connection related objects it's connection name.
	 * @return string
	 */
	public function name();
}

?>