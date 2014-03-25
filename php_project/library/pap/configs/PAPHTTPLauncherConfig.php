<?php

class PAPHTTPLauncherConfig {
	private function __construct(){
		
	}
	/**
	 * Path to call when module need to be launched. This path pounts to launcher HTTP location. 
	 * @var string
	 */
	const WRAPPER_PATH = 'wrapperPath';
	/**
	 * Launcher method that will be used. If not specified, Launcher will check all methods, to find first available method.   
	 * @var string
	 */
	const PREFFERED_METHOD = 'prefferedMethod';
	/**
	 *  Protocol that will be used to connect to wrapper.
	 * @var string
	 */
	const PROTOCOL = 'protocol';
	/**
	 * HTTP port connect to.
	 * @var unknown_type
	 */
	const PORT = 'port';
	/**
	 * Preffered m ethod by default is not exists -- method will be selected automatically.    
	 * @var string
	 */
	const DEFAULT_PREFFERED_METHOD = '';
	/**
	 *  Default protocol value.
	 * @var string
	 */
	const DEFAULT_PROTOCOL = 'http';
	/**
	 * Default port value.
	 * @var string
	 */
	const DEFAULT_PORT = '';
}

?>