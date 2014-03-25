<?php

/**
 * This call must contain data about module/client state that was initialized
 * @author iFrame
 *
 */
class PAPDataReadyState extends NonDynamicObject {
	/**
	 * ID of module connection
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
	public $index = -1;
	public $status = '';
	public $trustLevel = -1;
	/**
	 * 
	 * @var IDataGroup
	 */
	public $config = null;
	/**
	 * Environment info about all modules that launched or can be launched and accessible according to it's access level value.
	 * @var array
	 */
	public $environment;
}

?>