<?php

class PAPProtocolEntityReason {
	/**
	 * Must be sent only once, before any communication. When core requires authorization it sends auth codes, if not - send only module name. If not, module will be disconnected immediately.
	 * @var string
	 */
	const AUTHORIZATION = 'authorization';
	/**
	 * Ready state reason, will be sent to core from module after successful module initialization 
	 * @var string
	 */
	const READY_STATE = 'readyState';
	/**
	 * Module config, will be received right after successful connection, even before authorization.
	 * @var string
	 */
	const CONFIGURATION = 'configuration';
	/**
	 * Such entities will update info about launched modules core state and other such things. First received entity of this type will install environment, all other entities will update environment.
	 * @var string
	 */
	const ENVIRONMENT = 'environment';
}

?>