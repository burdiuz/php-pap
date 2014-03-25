<?php

/**
 * Config parameters and sub-groups that allowed in "launch" config group.
 * @author iFrame
 *
 */
class PAPLaunchConfig {
	private function __construct(){
		
	}
	/**
	 * Group that describes single module
	 * @var string
	 */
	const GROUP_MODULE = 'module';
	/**
	 * Module name, that will be launched
	 * @var string
	 */
	const NAME = 'name';
	/**
	 * Count of module instances that may be launched.
	 * @var string
	 */
	const INSTANCE_COUNT = 'instanceCount';
}

?>