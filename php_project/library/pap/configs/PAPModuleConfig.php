<?php

/**
 * Parameters and sub-groups that allowed for module configuration group.
 * Also, module configuration in root context MUST contain "connection" group.
 * Also, module configuration may contain groups: states
 * @see PAPStatesConfig
 * @author iFrame
 *
 */
class PAPModuleConfig {
	private function __construct(){
		
	}
	/**
	 * Group for module instance specific config. Module can be launched couple times at one time and this group contains config specific for each instance. This group is allowed only under core module configuration context.
	 * @var string
	 */
	const GROUP_INSTANCES = 'instances';
	/**
	 * This parameter value dynamicaly generated for each instance, it can not be predefined
	 * @var string
	 */
	const ID = 'id';
	/**
	 * Module name value. This name can be used when accessing module. Required parameter.
	 * @var string
	 */
	const NAME = 'name';
	/**
	 * Module path. Optional parameter, if not specified.
	 * @var string
	 */
	const PATH = 'path';
	/**
	 * Module working directory. Optional, temporary directory used by default.
	 * @var string
	 */
	const WORKING_DIR = 'workingDir';
	/**
	 * Data that will be pased to launcher as module parameters, separately from config.
	 * @var string
	 */
	const LAUNCH_PARAMETERS = 'launchParameters';
	/**
	 * Order of connection launchers that will be used while launching this module
	 * @var string
	 */
	const LAUNCHER_ORDER = 'launcherOrder';
	/**
	 * Order of connection types that will be used to connect module to core
	 * @var string
	 */
	const CONNECTION_ORDER = 'connectionOrder';
	/* DEPRECATED
	 * Connection name(or index, if no such name and it is a int type), that will be used to connect to this module. Optional, not specified, by default
	 * @var string
	const CONNECTION = 'connection';
	 */
	/**
	 * Minimum count of instances that can be launched at a time. Some of modules may require couple instances launched at one time. Optional, 0 by default.
	 * @var string
	 */
	const MINIMUM_INSTANCES = 'minInstances';
	/**
	 * Maximum count of instances that can be launched at a time. Optional, 0 by default.
	 * @var string
	 */
	const MAXIMUM_INSTANCES = 'maxInstances';
	/**
	 * Is module allowed to be restarted remotely, by trusted module.
	 * @var string
	 */
	const ALLOW_RESTART = 'allowRestart';
	/**
	 * If value bigger than 0 will be defined, core will restart this module by timeout in seconds.
	 * @var string
	 */
	const AUTORESTART_TIMEOUT = 'autorestartTimeout';
	/**
	 * Is module trusted by default. If 1, will receive highest trust level in 
	 * case when no authorization specified. If authorization keys specified, 
	 * this parameter will be ignored.
	 * @var string
	 */
	const TRUSTED_MODULE = 'trustedModule';
	/**
	 * Is module allowed to be shutdown remotely(by another trusted module).
	 * @var string
	 */
	const ALLOW_SHUTDOWN = 'allowShutdown';
	/**
	 * Is default module config can be changed remotely by another module. 
	 * Reconfigured module will not restart and will not recieve updated config 
	 * automatically, it must be restarted automatically and then will receive 
	 * new configuration. pap* configurations can not be overwritten. 
	 * @var string
	 */
	const ALLOW_RECONFIGURATION = 'allowReconfiguration';
	/**
	 * Is allowed to restart module when it crashes.
	 * @var string
	 */
	const ALLOW_RESTART_ON_CRASH = 'allowRestartOnCrash';
	/**
	 * Trust level required to contact with this module. Optional, 0 by default. 0 value means no requirements and even client can contact this module.
	 * @var string
	 */
	const ALLOW_ACCESS = 'allowAccess';
	/**
	 * Minimum count is not specified by default.
	 * @var int
	 */
	const DEFAULT_MINIMUM_INSTANCES = 0;
	/**
	 Maximum count is not specified by default.
	 * @var int
	 */
	const DEFAULT_MAXIMUM_INSTANCES = 0;
	/**
	 * Remote restart is not allowed by default
	 * @var int
	 */
	const DEFAULT_ALLOW_RESTART = 1;
	/**
	 * Autorestart is not allowed by default.
	 * @var int
	 */
	const DEFAULT_AUTORESTART_TIMEOUT = 0;
	/**
	 * Module is not trusted by default.
	 * @var int
	 */
	const DEFAULT_TRUSTED_MODULE = 0;
	/**
	 * Remote shutdown is not allowed by default.
	 * @var int
	 */
	const DEFAULT_ALLOW_SHUTDOWN = 1;
	/**
	 * Remote reconfiguration is not allowed by default.
	 * @var int
	 */
	const DEFAULT_ALLOW_RECONFIGURATION = 0;
	/**
	 * Restart module on crash is allowed by default.
	 * @var int
	 */
	const DEFAULT_ALLOW_RESTART_ON_CRASH = 1;
	/**
	 * Anyone can contact with module
	 * @var string
	 */
	const DEFAULT_ALLOW_ACCESS = 0;
	static public function exportParameters(IDataGroup $config, $removeAfterExport=true){
		$parameters = array();
		if($config->hasGroup(self::LAUNCH_PARAMETERS)){
			/** @var IDataLevels */ $levels = $config->group(self::LAUNCH_PARAMETERS);
			foreach($levels as /** @var IDataGroup */ $paramsGroup){
				foreach($paramsGroup as /** @var string */$key => $value){
					$parameters[$key] = $value;
				}
			}
			if($removeAfterExport){
				$config->groupManager()->remove(PAPModuleConfig::LAUNCH_PARAMETERS);
			}
		}
		return $parameters;
	}
}

?>