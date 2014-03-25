<?php

interface IPAPBasicConnection {
	/**
	 * Activate connection
	 * @return boolean
	 */
	public function connect();
	/**
	 * Is Connected
	 * @return boolean
	 */
	public function isConnected();
	/**
	 * Close connection
	 */
	public function close();
}

?>