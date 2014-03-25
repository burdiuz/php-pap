<?php

interface IPAPConnectionsHelper {
	public function connected(IPAPConnection $connection);
	public function disconnected(IPAPConnection $connection);
	/**
	 * Current protocol used
	 * @return IPAPProtocolService
	 */
	public function protocol();
	public function send(IPAPConnection $connection, PAPProtocolTransport $message);
	public function reportError(IPAPConnection $connection, $id, Exception $error);
}

?>