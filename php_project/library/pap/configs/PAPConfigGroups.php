<?php

/**
 * Main config groups list
 * @author iFrame
 *
 */
class PAPConfigGroups {
	private function __construct(){
		
	}
	/**
	 * General group for Core config
	 * @see PAPCoreConfig
	 * @var string
	 */
	const CORE = 'core';
	/**
	 * 
	 * @see PAPAuthorizationConfig
	 * @var string
	 */
	const AUTHORIZATION = 'authorization';
	/**
	 * Connections describing group
	 * @see PAPConnectionConfig
	 * @var string
	 */
	const CONNECTIONS = 'connections';
	/**
	 * Group for autorun modules that will be launched right after core initialization.
	 * @see PAPLaunchConfig
	 * @var string
	 */
	const LAUNCH = 'launch';
	/**
	 * Group with trusted modules list, each module node contains general info and any module specific config
	 * @see PAPModulesConfig
	 * @var string
	 */
	const MODULES = 'modules';
	/**
	 * Group for clients specific config, will be passed to every client that connected to Core
	 * @var string
	 */
	const CLIENTS = 'clients';
	/**
	 * General group for Module config
	 * @see PAPModuleConfig
	 * @var string
	 */
	const MODULE = 'module';
	/**
	 * General group for Client config
	 * @var string
	 */
	const CLIENT = 'client';
}

?>