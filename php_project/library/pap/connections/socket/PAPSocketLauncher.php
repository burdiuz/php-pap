<?php

class PAPSocketLauncher extends PAPLauncher{
	private $_method;
	private $_handlers = array();
	public function __construct(PAPLaunchersHelper $helper, PAPSocketConnectionConfig $config){
		parent::__construct($config->name, $helper, $config->rawConfig);
		if($config->prefferedMethod){
			$this->_prefferedMethod = $config->prefferedMethod;
		}else{
			$this->_prefferedMethod = self::getSupportedMethod();
		}
		$this->_socketConfig = $config;
		if(!$config->wrapperPath){
			throw new Exception('PAPSocketLauncher Error: "wrapperPath" must be defined in config.');
		}
	}
	public function typeDependency(){
		return PAPLauncherDependency::NOT_SIGNIFICANT;
	}
	protected function launchCommand($id, PAPModuleCommand $command){
		$method = 'write_'.$this->_prefferedMethod;
		$this->$method($id, $command);
	}
	protected function executeCommand($id, PAPModuleCommand $command){
		$method = 'read_'.$this->_prefferedMethod;
		$this->$method($id, $command);
	}
	private function finished($id, $data){
		if($data){
			/** @var Exception */ $error = null;
			/** @var PAPModuleLaunchStatus */ $status = null;
			try{
				$status = PAPModuleLaunchStatus::parse($data);
			}catch(Exception $error){}
			if(!$error && $status instanceof PAPModuleLaunchStatus){
				$this->handleLaunched($id, $status);
			}else{
				$this->handleLaunched($id, new PAPModuleLaunchStatus($id, PAPModuleLaunchStatus::RAW_OUTPUT, $data));
			}
		}else{
			$this->handleLaunched($id, new PAPModuleLaunchStatus($id, PAPModuleLaunchStatus::NO_OUTPUT, $data));
		}
	}
}

?>