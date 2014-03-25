<?php

class PAPConnectionConfig {
	/**
	 * Connection describing group
	 * @var string
	 */
	const GROUP_CONNECTION = 'connection';
	/**
	 * Connection protocol describing group
	 * @var string
	 */
	const GROUP_PROTOCOL = 'protocol';
	/**
	 * Connection name, if name not specified, will use string from index. Optional
	 * @var string
	 */
	const NAME = 'name';
	/**
	 * Path for additional classes, may be any count of such nodes. Optional
	 * @var string
	 */
	const PATH = 'path';
	/**
	 * Factory class name, that implement IPAPConnectionFactory. Required
	 * @var string
	 */
	const CONNECTION_FACTORY = 'factory';
	const PROTOCOL_SERVICE = 'service';
	const USE_CONFIRMATION = 'useConfirmation';
	private function __construct(){
		
	}
}

?>