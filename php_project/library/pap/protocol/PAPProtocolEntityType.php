<?php

class PAPProtocolEntityType {
	/**
	 * Any data passed to module or client. Data wil not be parsed by 
	 * @var string
	 */
	const DATA = 2;
	/**
	 * The same as Data, but will be parsed with unserialize(), standart method. Means that destination awaits for PHP objects and data  
	 * @var unknown_type
	 */
	const VARS = 4;
	/**
	 * Event data, will be dispatched in destination module/client
	 * @var unknown_type
	 */
	const EVENT = 8;
	/**
	 * Request for module API property value
	 * @var int
	 */
	const API_PROPERTY = 16;
	/**
	 * Request for module API method call
	 * @var int
	 */
	const API_METHOD = 32;
	/**
	 * In any case, destination of this data will be logger module(registered as logger).
	 * @var unknown_type
	 */
	const LOG = 512;
	/**
	 * Error message, core will shut down source module and send LOG for logger module, if it is registered.
	 * @var Exception
	 */
	const ERROR = 1024;
}

?>