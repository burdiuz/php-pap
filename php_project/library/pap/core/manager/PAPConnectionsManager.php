<?php

/**
 * Facade object for all connections to core
 * @author iFrame
 *
 */
class PAPConnectionsManager{
	/**
	 * Registry for Module IDs reservation
	 * @var PAPModuleRegistry
	 */
	protected $_registry;
	/**
	 * Module commands collections. Command is a module definition
	 * @var PAPDefinitionsCollection
	 * @see PAPModuleCommand
	 */
	protected $_definitions;
	/**
	 * Named collection of IPAPLauncher instances
	 * @var PAPLaunchersCollection
	 * @see IPAPLauncher
	 */
	protected $_launchers;
	/**
	 * Collection of IPAPConnection instances, that represents already connected and authorized instances
	 * @var PAPConnectionsCollection
	 * @see IPAPConnection
	 */
	protected $_connections;
	/**
	 * Named collection of IPAPConnectionInspector instances, each represents connection listener that focused on a new self initiated connections
	 * @var PAPInspectorsCollection
	 * @see IPAPConnectionInspector
	 */
	protected $_inspectors;
	/**
	 * Just a catalog of needed helpers to support connections
	 * @var PAPConnectionsManagerHelpers
	 * @see PAPConnectionsHelper
	 * @see PAPInspectorsHelper
	 * @see PAPLaunchersHelper
	 */
	protected $_helpers;
	/**
	 * @var IDataGroup
	 */
	private $_config;
	/**
	 * @var IPAPProtocolService
	 */
	private $_protocol;
	/** 
	 * @var PAPAuthorization
	 */
	private $_authorization;
	/** 
	 * @var boolean
	 */
	private $_connected;
	public function __construct(IDataGroup $config=null, IDataGroup $moduleConfig=null, IDataGroup $clientConfig=null){
		$this->_config = $config;
		$this->_registry = new PAPModuleRegistry();
		$this->_launchers = new PAPLaunchersCollection();
		$this->_connections = new PAPConnectionsCollection();
		$this->_inspectors = new PAPInspectorsCollection();
		$this->_helpers = new PAPConnectionsManagerHelpers($this);
		$this->readConfig($config ? $config : self::getDefaultConfig(), $moduleConfig, $clientConfig);
	}
	private function readConfig(IDataGroup $config, IDataGroup $moduleConfig=null, IDataGroup $clientConfig=null){
		$this->_dictionary = new PAPDefinitionsCollection($config->hasGroup(PAPConfigGroups::MODULES) ? $config->group(PAPConfigGroups::MODULES)->level(0) : null, $moduleConfig, $clientConfig);
		$this->_authorization = PAPAuthorization::getInstance($config->hasGroup(PAPConfigGroups::AUTHORIZATION) ? $config->group(PAPConfigGroups::AUTHORIZATION)->level(0) : null);
		if($config->hasGroup(PAPConfigGroups::CONNECTIONS)){
			/** @var IDataGroup */
			$group = $config->group(PAPConfigGroups::CONNECTIONS)->level(0);
			$this->_protocol = PAPConnectionsManagerParser::getProtocolService($group);
			PAPConnectionsManagerParser::applyDefinedConnections($this, $group);
		}else{
			$this->_protocol = DefaultProtocolService::getInstance(null);
		}
	}
	/**
	 * @return PAPDefinitionsCollection
	 */
	public function definitions(){
		return $this->_definitions;
	}
	/**
	 * @return PAPInspectorsCollection
	 */
	public function inspectors(){
		return $this->_inspectors;
	}
	/**
	 * @return PAPLaunchersCollection
	 */
	public function launchers(){
		return $this->_launchers;
	}
	/**
	 * @return PAPConnectionsCollection
	 */
	public function connections(){
		return $this->_connections;
	}
	/**
	 * @return PAPModuleRegistry
	 */
	public function registry(){
		return $this->_registry;
	}
	/**
	 * @return PAPConnectionsManagerHelpers
	 */
	public function helpers(){
		return $this->_helpers;
	}
	/**
	 * IPAPProtocolService instance that was used to communicate between connections 
	 * @return IPAPProtocolService
	 */
	public function protocol(){
		return $this->_protocol;
	}
	/**
	 * Connections configuration
	 * @return IDataGroup
	 */
	public function config(){
		return $this->_config;
	}
	
	
	
	
    /**
     * Launch module by name and level index, will use specific connection if defined
     * @param string $name
     * @param int $index
     * @param string $connectionName
     * @return boolean
     */
    public function launch($name,  $index=-1, $connectionName=''){
    	$id = PAPUtils::getUniqueModuleId($name);
   		/** @var PAPModuleCommand */
   		$command = null;
    	if($this->_definitions->has($name)){
    		/** @var PAPCommandLevels */
    		$levels = $this->_definitions->get($name);
    		$command = $levels->command($index);
    	}else{
	    	/** @var IDataGroup */
	    	$config = $this->_definitions->defaultModuleConfig();
    		if(!$config){
    			throw new Exception('PAPConnectionsManager Error: Module command not found');
    		}
    		$command = new PAPModuleCommand($config);
    	}
    	$this->_registry->add($id, null, $name,  $index);
    	$launched = $this->_launchers->launchModule($id, $command, $connectionName ? array($connectionName) : null);
    	if(!$launched) $this->_registry->remove($id);
    	return $launched;
    }
    /**
     * Module RAW launch, will pass this launch right to launcher and only when connection will be established, will add it to all other modules.
     * For modules launched in this way levels disabled, so module can have only one and only first level.
     * @param PAPModuleCommand $command
     * @param string $connectionName
     * @return boolean
     */
    public function rawLaunch(PAPModuleCommand $command, $connectionName=''){
    	$name = $command->name();
    	$id = PAPUtils::getUniqueModuleId($name);
    	$this->_registry->add($id, null, $name);
    	$launched = $this->_launchers->launchModule($id, $command, $connectionName ? array($connectionName) : null);
    	if(!$launched) $this->_registry->remove($id);
    	return $launched;
    }
    public function registerModule(IDataGroup $config){
    	return $this->_definitions->register($config);
    }
    public function bindConnectionId($name='', $level=-1){
    	$id = PAPUtils::getUniqueModuleId($name);
    	$this->_registry->add($id, null, $name, $level);
    	return $id;
    }
    public function unbindConnectionId($connectionId){
    	$this->_registry->remove($connectionId);
    }
    public function addConnection(IPAPConnection $connection){
    	$name = $connection->moduleName();
    	$level = $connection->moduleLevel();
    }
	static private function getDefaultConfig(){
		return new DataGroup();
	}
}

?>