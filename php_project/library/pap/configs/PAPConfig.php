<?php

class PAPConfig extends NonDynamicObject {
	const INPUT_CONFIG_PARAMETER = 'configFile';
	/**
	 * Global configuration
	 * @var IDataGroup
	 */
	static private $_global;
	private function __construct(){
		
	}
	/**
	 * Set global config
	 * @param IDataGroup $config
	 */
	static public function setGlobal(IDataContainer $config){
		self::$_global = $config;
	}
	/**
	 * @return IDataGroup
	 */
	static public function getGlobal(){
		return self::$_global;
	}
	/**
	 * Will copy basic config groups: connections, states into new config group
	 * @param IDataGroup $config
	 * @return IDataGroup
	 */
	static public function copyBasicConfig(IDataGroup $config){
		/** @var IDataGroup */ $copy = new DataGroup();
		/** @var IDataGroupManager */ $copyManager = $copy->groupManager();
		if($config->hasGroup(PAPConfigGroups::CONNECTIONS)) $copyManager->add(PAPConfigGroups::CONNECTIONS, clone $config->group(PAPConfigGroups::CONNECTIONS)->level(0));
		if($config->hasGroup(PAPConfigGroups::STATES)) $copyManager->add(PAPConfigGroups::STATES, clone $config->group(PAPConfigGroups::STATES)->level(0));
		return $copy;
	}
	/**
	 * Will clone entire config from source to destination, replacing groups and values.
	 * @param IDataGroup $source
	 * @param IDataGroup $destination
	 * @return IDataGroup
	 */
	static public function copyConfig(IDataGroup $source, IDataGroup $destination=null, $cloneDestination=false){
		if($source instanceof IDataLevels) $source = $source->level(0);
		if($destination instanceof IDataLevels) $destination = $source->level(0);
		if($destination && $cloneDestination){
			$cloned = new DataGroup(clone $destination->values());
			/** @var IDataContainerManager */ $dataManager = $cloned->dataManager();
			foreach($source as $name=>$value){
				$dataManager->set($name, $value);
			}
			/** @var IDataGroupManager */ $groupManager = $cloned->groupManager();
			/** @var Iterator */ $groupsIterator = $destination->groupsIterator();
			$groupsIterator->rewind();
			while($groupsIterator->valid()){
				$name = $groupsIterator->key();
				if(!$source->hasGroup($name)){
					$groupManager->set($name, clone $groupsIterator->current());
				}
				$groupsIterator->next();
			}
			$groupsIterator = $source->groupsIterator();
			$groupsIterator->rewind();
			while($groupsIterator->valid()){
				$groupManager->set($groupsIterator->key(), clone $groupsIterator->current());
				$groupsIterator->next();
			}
			$destination = $cloned;
		}else{
			if($destination){
				/** @var IDataContainerManager */ $dataManager = $destination->dataManager();
				foreach($source as $name=>$value){
					$dataManager->set($name, $value);
				}
			}else{
				$destination = new DataGroup(clone $source->values());
			}
			/** @var IDataGroupManager */ $groupManager = $destination->groupManager();
			/** @var Iterator */ $groupsIterator = $source->groupsIterator();
			$groupsIterator->rewind();
			while($groupsIterator->valid()){
				$groupManager->set($groupsIterator->key(), clone $groupsIterator->current());
				$groupsIterator->next();
			}
		}
		return $destination;
	}
	static public function readInput($setGlobal=true){
		global $argv;
		/**
		 * @var array
		 */
		$parameters = array();
		if(defined('STDIN')){ // CLI
			$parameters = $argv ? self::convertArguments($argv) : array();
		}else{
			$parameters = $_GET;
		}
		/**
		 * @var IDataGroup
		 */
		$config = new DataGroup();
		if(isset($parameters[self::INPUT_CONFIG_PARAMETER])){
			self::loadXML($parameters[self::INPUT_CONFIG_PARAMETER], $config);
		}
		unset($parameters[self::INPUT_CONFIG_PARAMETER]);
		self::integrateArray($config, $parameters);
		if($setGlobal) self::setGlobal($config);
		return $config;
	}
}

?>