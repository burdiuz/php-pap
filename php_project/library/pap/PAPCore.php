<?php

/**
 * Ядро должно мониторить модули и распределять сообщения
 * @author iFrame
 *
 */ 
class PAPCore extends EventDispatcher{
	static private $_instance;
	/**
	 * Connections manager
	 * @var IPAPConnectionManager
	 */
	private $_manager;
	/**
	 * Connection to logger module
	 * @var IPAPConnection
	 */
	private $_logger;
	/**
	 * IWorkingCycle instance
	 * @var IWorkingCycle
	 */
	private $_workingCycle;
	public function __construct(IDataGroup $config, IDataGroup $moduleConfig, IDataGroup $clientConfig){
		parent::__construct($config);
		$this->_manager = new PAPConnectionsManager($config, $moduleConfig, $clientConfig);
		$this->_workingCycle;
	}
	//TODO всё перенести в класс интернал и тик запускать из него.
	protected function tick(){
		echo " - tick(".time().")\r\n";
		$anyData =	$this->_manager->read();
					$this->_manager->write();
		return $anyData;
	}
	static public function initialize(){
		/** @var IDataGroup */ $config = PAPConfig::getGlobal();
		/** @var IDataGroup */ $coreConfig = $config;
		if($config->hasGroup(PAPConfigGroups::CORE)){
			$coreConfig = $config->group(PAPConfigGroups::CORE)->level(0);
		}
		/** @var IDataGroup */ $moduleConfig = PAPConfig::copyBasicConfig($coreConfig);
		/** @var IDataGroup */ $clientConfig = PAPConfig::copyBasicConfig($coreConfig);
		if($config->hasGroup(PAPConfigGroups::CORE)){
			if($config->hasGroup(PAPConfigGroups::MODULE)) PAPConfig::copyConfig($config->group(PAPConfigGroups::MODULE)->level(0), $moduleConfig);
			if($config->hasGroup(PAPConfigGroups::CLIENT)) PAPConfig::copyConfig($config->group(PAPConfigGroups::CLIENT)->level(0), $clientConfig);
		}
		// add connect handler to manager and launch autorun modules 
		self::$_instance = new PAPCore($coreConfig, $moduleConfig, $clientConfig);
	}
	static public function instance(){
		return self::$_instance;
	}
}
?>