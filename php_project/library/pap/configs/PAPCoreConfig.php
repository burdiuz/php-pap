<?php

/**
 * Allowed parameters for core configuration group.
 * Also MUST contain sub-group "connection".
 * Also MAY contain sub-groups: authorization, states, launch, httpLauncher, modules, clients.
 * @see PAPConnectionConfig
 * @see PAPAuthorizationConfig
 * @see PAPStatesConfig
 * @see PAPLaunchConfig
 * @see PAPHTTPLauncherConfig
 * @see PAPModulesConfig
 * @see PAPClientsConfig
 * @author iFrame
 *
 */
class PAPCoreConfig {
	private function __construct(){
		
	}
	/**
	 * Determine if clients allowed to start core if no connection is found.
	 * @var string
	 */
	const ALLOW_CLIENT_INITIATION = 'allowClientInitiation';
	/**
	 * Name of module that can receive and store LOG messages. It will be launched firstly and will be restarted immediatly at crash or shutdown.
	 * @var string
	 */
	const LOGGER_MODULE = 'loggerModule';
}

?>