<?php

/**
 * Класс для запуска модулей(и ядра из клиента). 
 * Он вызывается только ядром(клиент отправляет сообщеие в ядро этому модулю, а ядро запускает модуль, если он ещё не запущен). 
 * Этот класс выведен в базовое пространство имён просто для удобства вызова.
 * @author iFrame
 *
 */
abstract class PAPLauncher extends HandlerHolder implements IPAPLauncher {
	/**
	 * @var IPAPProtocolService
	 */
	protected $_protocol;
	/**
	 * @var PAPLaunchersHelper
	 */
	protected $_helper;
	/**
	 * @var boolean
	 */
	protected $_connected;
	/**
	 * @var IDataGroup
	 */
	protected $_config;
	/**
	 * @var string
	 */
	protected $_name;
	/**
	 * @var array
	 */
	protected $_queue = array();
	public function __construct($name, PAPLaunchersHelper $helper, IDataGroup $config=null){
		$this->_name = $name;
		$this->_helper = $helper;
		$this->_protocol = $helper->protocol();
		$this->_config = $config;
	}
	public function name(){
		return $this->_name;
	}
	public function config(){
		return $this->_config;
	}
	public function connect(){
		$this->_connected = true;
	}
	public function isConnected(){
		return $this->_connected;
	}
	public function close(){
		$this->_connected = false;
	}
	public function launch($id, PAPModuleCommand $command){
		if($this->_connected && $command && $this->launchCommand($id, $command)){
			$this->_queue[$id] = $command;
			return true;
		}
		return false;
	}
	public function canLaunch(PAPModuleCommand $command){
		return true;
	}
	/**
	 * Initiate module connection
	 * @param string $id
	 * @param PAPModuleCommand $command
	 */
	protected function launchCommand($id, PAPModuleCommand $command){
		
	}
	public function execute(){
		if($this->_connected){
			foreach($this->_queue as /** @var string */ $id => /** @var PAPModuleCommand */ $command){
				$this->executeCommand($id, $command);
			}
		}
	}
	/**
	 * Read data from module, check is it launched correctly
	 * @param string $id
	 * @param PAPModuleCommand $command
	 */
	protected function executeCommand($id, PAPModuleCommand $command){
		
	}
	protected function handleLaunched($id, $data=null){
		$this->callHandler(PAPLauncherActions::LAUNCHED, $this, $id, $this->_queue[$id], $data);
		unset($this->_queue[$id]);
	}
}
?>