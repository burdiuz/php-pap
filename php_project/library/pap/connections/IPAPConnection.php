<?php

/**
 * Connections interface for modules, core and clients
 * @author Oleg
 *
 */
interface IPAPConnection extends IHandlerHolder, INamedEntity, IPAPBasicConnection, IExecutable{
	/**
	 * Get connection Id
	 * Must be received from core.
	 * @return string
	 */
	public function id();
	/**
	 * Set connection's Id. Id value must be temporary and unique per connection.
	 * @param string $value
	 */
	public function setId($value);
	/**
	 * Set connection's name, can be specified by launcher, inspector or by module itself. By name client can get access to module, this names are static values.
	 * @param string $value
	 */
	public function setName($value);
	/**
	 * Get module name
	 * Must be received from core.
	 * @return int
	 */
	public function moduleName();
	/**
	 * Get module level
	 * Must be received from core.
	 * @return int
	 */
	public function moduleLevel();
	/**
	 * 
	 * @param int $value
	 */
	public function setModuleLevel($value);
	/**
	 * Get trust level.
	 * Must be received from core.
	 * @return int
	 */
	public function trustLevel();
	/**
	 * Set trust level for connection
	 * @param int $value
	 */
	public function setTrustLevel($value);
	/**
	 * Add entity to pool for writing into connection's input. After adding this entity it will wait for writing, after that pool will be cleared.
	 * @param IPAPProtocolEntity $entity
	 */
	public function send(IPAPProtocolEntity $entity);
	/**
	 * Read data from connection buffer
	 * @return IPAPProtocolEntity[]
	 */
	public function read();
	/**
	 * Write data to connection's input
	 */
	public function write();
}

?>