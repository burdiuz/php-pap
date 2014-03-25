<?php

class PAPDataGreeting extends NonDynamicObject {
	/**
	 * 
	 * @var string
	 */
	public $id;
	/**
	 * If name defined, module connected, if no -- client.
	 * @var string
	 */
	public $name = '';
	/**
	 * 
	 * @var int
	 */
	public $level = -1;
	/**
	 * 
	 * @var boolean
	 */
	public $requiresConfig = false;
	/**
	 * 
	 * @var string[]
	 */
	public $authorizationKeys = null;
}

?>