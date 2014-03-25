<?php

/**
 * Config parameters and sub-groups allowed for authorization group
 * @author iFrame
 *
 */
class PAPAuthorizationConfig {
	private function __construct(){
		
	}
	/**
	 * Group of authorization keys for highly trusted modules 
	 * @var string
	 */
	const GROUP_HIGH = 'high';
	/**
	 * Group of authorization keys for trusted modules 
	 * @var string
	 */
	const GROUP_MEDIUM = 'medium';
	/**
	 * Group of authorization keys for not trusted modules and clients 
	 * @var string
	 */
	const GROUP_LOW = 'low';
	/**
	 * If specified, will define special authorization for clients, separate from modules authorization.
	 * @var string
	 */
	const GROUP_CLIENT = 'client';
	/**
	 * Contins single authorization key value
	 * @var string
	 */
	const KEY = 'key';
}

?>