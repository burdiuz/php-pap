<?php

/**
 * Connection inspector waits nor new incoming connections.
 * @author iFrame
 *
 */
interface IPAPConnectionInspector extends INamedEntity, IPAPBasicConnection, IExecutable{
	/**
	 * Read host connection for new client connections
	 * @return IPAPHostConnection[]
	 */
	public function read();
}

?>