<?php

class PAPConnectionActions {
	private function __construct(){}
	/**
	 * Connected
	 * @var string
	 */
	const CONNECTED = 'connected';
	/**
	 * Any ProtocolEntity received, precedes calling handler for specific type of protocol entity.
	 * @var string
	 */
	const PROTOCOL_ENTITY_RECEIVED = 'protocolEntityReceived';
	/**
	 * Data sent and confirmation received
	 * @var string
	 */
	const PROTOCOL_ENTITY_SENT = 'protocolEntitySent';
	/**
	 * ProtocolEntity with Data received
	 * @var string
	 */
	const DATA_RECEIVED = 'dataReceived';
	/**
	 * ProtocolEntity with Event received
	 * @var string
	 */
	const EVENT_RECEIVED = 'eventReceived';
	/**
	 * ProtocolEntity with Log message received
	 * @var string
	 */
	const LOG_RECEIVED = 'logReceived';
	/**
	 * ProtocolEntity with Error received
	 * @var string
	 */
	const ERROR_RECEIVED = 'errorReceived';
	/**
	 * Error occured
	 * @var string
	 */
	const ERROR = 'error';
	/**
	 * Disconnected
	 * @var string
	 */
	const DISCONNECTED = 'disconnected';
	/**
	 * Client connected and waits for authorization
	 * @var string
	 */
	const CLIENT_CONNECTED = 'clientConnected';
	/**
	 * Client disconnected
	 * @var string
	 */
	const CLIENT_DISCONNECTED = 'clientDisconnected';
	/**
	 * Client authorization approved
	 * @var string
	 */
	const CLIENT_APPROVED = 'clientApproved';
	/**
	 * Client authorization rejected
	 * @var string
	 */
	const CLIENT_REJECTED = 'clientRejected';
}

?>