<?php

class PAPCommandLevels extends NonDynamicObject{
	private $_name;
	private $_registered;
	/**
	 * 
	 * @var PAPModuleCommand[]
	 */
	private $_commands = array();
	private $_defaultCommand;
	private $_minInstances = 0;
	private $_maxInstances = 1;
	public function __construct($data){
		if($data instanceof IDataGroup){
			$this->installByConfig($data);
		}elseif($data instanceof PAPModuleCommand){
			$this->installByCommand($data);
		}else{
			throw new Exception('PAPCommandLevels Error: Insufficient data.');
		}
		if(!$this->_name){
			throw new Exception('PAPCommandLevels Error: Module must define its name.');
		}
	}
	private function installByConfig(IDataGroup $config){
		$this->_registered = true;
		$this->_name = $config->value(PAPModuleConfig::NAME);
		$this->_minInstances = $config->value(PAPModuleConfig::MINIMUM_INSTANCES, PAPModuleConfig::DEFAULT_MINIMUM_INSTANCES);
		$this->_maxInstances = $config->value(PAPModuleConfig::MAXIMUM_INSTANCES, PAPModuleConfig::DEFAULT_MAXIMUM_INSTANCES);
		$this->_defaultCommand = new PAPModuleCommand($config, $this->_name);
		if($config->hasGroup(PAPModuleConfig::GROUP_INSTANCES)){
			/** @var IDataLevels */ $instances = $config->group(PAPModuleConfig::GROUP_INSTANCES)->group(PAPInstancesConfig::GROUP_INSTANCE);
			$config->groupManager()->remove(PAPModuleConfig::GROUP_INSTANCES);
			if($instances->count()){
				$index = 0;
				foreach($instances as /** @var IDataGroup */ $instance){
					$instanceIndex = 0;
					if($instance->hasValue(PAPInstancesConfig::INDEX)){
						$instanceIndex = (int)$instance->value(PAPInstancesConfig::INDEX);
						$instance->dataManager()->remove(PAPInstancesConfig::INDEX);
					}else{
						$instanceIndex = $index;
						$index++;
					}
					$this->_commands[$instanceIndex] = new PAPModuleCommand(PAPConfig::copyConfig($instance, $config, true), $this->_name, $instanceIndex);
				}
			}
		}
	}
	private function installByCommand(PAPModuleCommand $command){
		$this->_registered = false;
		$this->_name = $command->name();
		$this->_defaultCommand = $command;
		$this->_minInstances = PAPModuleConfig::DEFAULT_MINIMUM_INSTANCES;
		$this->_maxInstances = PAPModuleConfig::DEFAULT_MAXIMUM_INSTANCES;
	}
	public function name(){
		return $this->_name;
	}
	public function isRegistered(){
		return $this->_registered;
	}
	public function command($index=0){
		return isset($this->_commands[(int)$index]) ? $this->_commands[(int)$index] : $this->_defaultCommand;
	}
	public function parameters($index=0){
		return $this->command($index)->parameters();
	}
	public function config($index=0){
		return $this->command($index)->config();
	}
	public function minInstances(){
		return $this->_minInstances;
	}
	public function maxInstances(){
		return $this->_maxInstances;
	}
	public function path($index=0){
		return $this->command($index)->path();
	}
	public function workingDir($index=0){
		return $this->command($index)->workingDir();
	}
	public function getConfigValue($name, $default=null, $index=0){
		return $this->command($index)->config()->value($name, $default);
	}
	public function allowRestart($index=0){
		return (boolean)$this->getConfigValue(PAPModuleConfig::ALLOW_RESTART, PAPModuleConfig::DEFAULT_ALLOW_RESTART, $index);
	}
	public function autorestartTimeout($index=0){
		return $this->getConfigValue(PAPModuleConfig::AUTORESTART_TIMEOUT, PAPModuleConfig::DEFAULT_AUTORESTART_TIMEOUT, $index);
	}
	public function trustedModule($index=0){
		return (boolean)$this->getConfigValue(PAPModuleConfig::TRUSTED_MODULE, PAPModuleConfig::DEFAULT_TRUSTED_MODULE, $index);
	}
	public function allowShutdown($index=0){
		return (boolean)$this->getConfigValue(PAPModuleConfig::ALLOW_SHUTDOWN, PAPModuleConfig::DEFAULT_ALLOW_SHUTDOWN, $index);
	}
	public function allowReconfiguration($index=0){
		return (boolean)$this->getConfigValue(PAPModuleConfig::ALLOW_RECONFIGURATION, PAPModuleConfig::DEFAULT_ALLOW_RECONFIGURATION, $index);
	}
	public function allowRestartOnCrash($index=0){
		return (boolean)$this->getConfigValue(PAPModuleConfig::ALLOW_RESTART_ON_CRASH, PAPModuleConfig::DEFAULT_ALLOW_RESTART_ON_CRASH, $index);
	}
	public function allowAccess($index=0){
		return $this->getConfigValue(PAPModuleConfig::ALLOW_ACCESS, PAPModuleConfig::DEFAULT_ALLOW_ACCESS, $index);
	}
	public function __destruct(){
		$this->_defaultCommand = null;
		$this->_minInstances = 0;
		$this->_maxInstances = 0;
	}
}

?>