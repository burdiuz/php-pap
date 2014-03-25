<?php

class PAPLaunchersCollection extends PAPConnectionsManagerCollection {
	/**
	 * 
	 * @var ExecutableList
	 */
	private $_executables;
	public function __construct(){
		parent::__construct(false, true);
		$this->_executables = new ExecutableList(false, true);
	}
	/**
	 * 
	 * @param string $connectionType
	 * @return IPAPLauncher[]
	 */
	public function getLaunchers($connectionType){
		/** @var ExecutableList */$list = $this->getItems($connectionType);
		return $list ? $list->toArray() : array();
	}
	/**
	 * 
	 * @param string $connectionType
	 * @param IPAPLauncher $launcher
	 */
	public function addLauncher(IPAPLauncher $launcher){
		$this->addItem($launcher->name(), $launcher);
	}
	/**
	 * 
	 * @param string $connectionType
	 * @param IPAPLauncher[] $list
	 */
	public function addLaunchers($connectionType, $list){
		$this->addItems($connectionType, $list);
	}
	/**
	 * 
	 * @param string $connectionType
	 * @param IPAPLauncher $launcher
	 */
	public function removeLauncher(IPAPLauncher $launcher){
		$this->removeItem($launcher->name(), $launcher);
	}
	/**
	 * 
	 * @param string $connectionType
	 */
	public function removeLaunchers($connectionType){
		$this->removeItems($connectionType);
	}
	/**
	 * Add launcher to executable list
	 * @param IPAPLauncher $launcher
	 * @return boolean
	 */
	public function connectLauncher(IPAPLauncher $launcher){
		if($this->isNamedItemExists($launcher)){
			$this->_executables->addItem($launcher);
			return true;
		}
		return false;
	}
	/**
	 * Remove launcher from executable list
	 * @param IPAPLauncher $launcher
	 * @return boolean
	 */
	public function disconnectLauncher(IPAPLauncher $launcher){
		return (boolean)$this->_executables->removeItem($launcher);
	}
    /**
     * Detect compatible launcher and pass command to this launcher 
     * @param string $id
     * @param PAPModuleCommand $command
     * @param array $launcherOrder
     * @return boolean
     */
    public function launchModule($id, PAPModuleCommand $command, $launcherOrder=null){
    	/** @var IExecutableHash */ $hash = $this->getAll();
    	/** @var IDataGroup */ $config = $command->config();
    	$configOrder = $config->value(PAPModuleConfig::LAUNCHER_ORDER, array());
    	if(!is_array($configOrder)) $configOrder = array((string)$configOrder);
    	if($launcherOrder) $launcherOrder = array_merge($launcherOrder, $configOrder);
    	else $launcherOrder = $configOrder;
    	if($launcherOrder){
    		foreach($launcherOrder as /** @var string */$connectionType){
    			if(!$hash->hasKey($connectionType)) continue;
    			/** @var IExecutableList */ $launchers = $hash->get($connectionType);
    			foreach($launchers as /** @var IPAPLauncher */ $launcher){
    				if($launcher->isConnected()){
    					if($launcher->launch($id, $command)) return true;
    				}
    			}
    		}
    	}else{
    		// здесь обрабатывается $hash, а не $this->_executables, потому что важен порядок обработки
    		foreach($hash as /** @var IExecutableList */ $launchers){
    			foreach($launchers as /** @var IPAPLauncher */ $launcher){
    				if($launcher->isConnected()){
    					if($launcher->launch($id, $command)) return true;
    				}
    			}
    		}
    	}
    	return false;
    }
	public function execute(){
		$this->_executables->execute();
	}
}

?>