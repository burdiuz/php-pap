<?php

interface IOutputDestination {
	/**
	 * Data to write into output
	 * @param string $data
	 */
	public function write($data);
}

?>