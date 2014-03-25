<?php

/**
 * Contains registered modules that can be launched by name
 * @author Oleg
 *
 */
class PAPDefinitionsCollection extends NonDynamicObject {
	/**
	 * Registered modules, that can be launched by name
	 * @see PAPModuleCommand
	 * @see PAPCommandLevels
	 * @var array
	 */
	private $_modules;
	/**
	 * Will be used as base config for all registered modules and as main config for not registered modules.
	 * @var IDataGroup
	 */
	public $_moduleConfig;
	/**
	 * Client config, will be passed to each client that will try to connect
	 * @var IDataGroup
	 */
	public $_clientConfig;
	/**
	 * Default modules path from core config
	 * @var string
	 */
	private $_path;
	/**
	 * Default working dir, if not specified, temporary folder will be used.
	 * @var string
	 */
	private $_workingDir;
	public function __construct(IDataGroup $config=null, IDataGroup $moduleConfig=null, IDataGroup $clientConfig=null){
		$this->_moduleConfig = $moduleConfig;
		$this->_clientConfig = $clientConfig;
		$this->_modules = array();
		if($config){
			$this->readConfig($config);
		}else{
			$this->_path = '';
			$this->_workingDir = rtrim(realpath(sys_get_temp_dir()), '/').'/';
		}
	}
	private function readConfig(IDataGroup $config){
		$this->_path = $config->value(PAPModulesConfig::PATH, '');
		$this->_workingDir = rtrim(realpath($config->value(PAPModulesConfig::WORKING_DIR, sys_get_temp_dir())), '/').'/';
		if($config->hasGroup(PAPModulesConfig::GROUP_MODULE)){
			/** @var IDataLevels */
			$modules = $config->group(PAPModulesConfig::GROUP_MODULE);
			foreach($modules as /** @var IDataGroup */$module){
				$this->register($module);
			}
		}
	}
	public function add(IDataGroup $config){
		if($config && $config->hasValue(PAPModuleConfig::NAME)){
			$name = $config->value(PAPModuleConfig::NAME);
			if(isset($this->_modules[$name])){
				throw new Exception('PAPDictionary Error: Module with the same name "'.$name.'" already registered.');
			}else{
				/** @var PAPCommandLevels */ $moduleLevels = new PAPCommandLevels($config);
				$this->_modules[$name] = $moduleLevels;
				return $moduleLevels;
			}
		}
		return false;
	}
	/**
	 * @param string $name
	 * @return PAPCommandLevels
	 */
	public function get($name){
		return isset($this->_modules[$name]) ? $this->_modules[$name] : null;
	}
	public function has($name){
		return isset($this->_modules[$name]);
	}
	/**
	 * 
	 * @return IDataGroup
	 */
	public function defaultModuleConfig(){
		return $this->_moduleConfig;
	}
	/**
	 * 
	 * @return IDataGroup
	 */
	public function defaultClientConfig(){
		return $this->_clientConfig;
	}
    /**
     * Will register module and each defined module level, create module launching commands.
     * Specific level cannot be registered separately, reregistration will throw exception.
     * @param IDataGroup $config
     * @return boolean
     */
    public function register(IDataGroup $config, $silent=false){
    	if(!$config) return;
		/** @var IDataGroupManager */
		$manager = $config->dataManager();
		if(!$manager->has(PAPModuleConfig::PATH) && $this->_path) $manager->set(PAPModuleConfig::PATH, $this->_path);
		if(!$manager->has(PAPModuleConfig::WORKING_DIR) && $this->_workingDir) $manager->set(PAPModuleConfig::WORKING_DIR, $this->_workingDir);
		/** @var PAPCommandLevels */
		$moduleLevels = new PAPCommandLevels(PAPConfig::copyConfig($config, $this->_moduleConfig, true));
		/** @var string */
		$name = $moduleLevels->name();
		if($this->isRegistered($name)){
			if(!$silent){
				throw new Exception('PAPDefinitionsCollection Error: Module "'.$name.'" already registered and cannot be added');
			}
			return false;
		}else{
			$this->_modules[$moduleLevels->name()] = $moduleLevels;
		}
		return true;
    }
    /**
     * Is module registered
     * @param string $name
     */
    public function isRegistered($name){
    	return isset($this->_modules[$name]);
    }
}

?>