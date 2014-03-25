<?php

abstract class PAPConnectionsManagerParser {
	/**
	 * Will return instance of IPAPProtocolService
	 * @param IDataGroup $config Connections group, that contains protocol value or group
	 * @return IPAPProtocolService
	 */
	static public function getProtocolService(IDataGroup $group=null){
		/** @var IPAPProtocolService */
		$protocol = null;
		$defined = array();
		if($group->hasValue(PAPConnectionConfig::GROUP_PROTOCOL)){
			$values = $group->value(PAPConnectionConfig::GROUP_PROTOCOL);
			if(!is_array($values)) $values = array($values);
			foreach($values as /** @var string */ $value){
				if(!$value){
					throw new Exception('PAPConnectionsManagerParser Error: Required protocol name must be set and must be not empty string');
				}
				$defined[$value] = null;
			}
		}
		if($group->hasGroup(PAPConnectionConfig::GROUP_PROTOCOL)){
			/** @var IDataLeves */
			$levels = $group->group(PAPConnectionConfig::GROUP_PROTOCOL);
			foreach($levels as /** @var IDataGroup */ $level){
				$value = '';
				if($level->hasValue(PAPConnectionConfig::PROTOCOL_SERVICE)){
					$value = $level->value(PAPConnectionConfig::PROTOCOL_SERVICE);
					if(is_array($value)) $value = array_shift($value);
				}
				if(!$value){
					throw new Exception('PAPConnectionsManagerParser Error: Required protocol name must be set and must be not empty string');
				}
				$defined[$value] = $level;
			}
		}
		foreach($defined as /** @var string */ $service=>/** @var IDataGroup */ $config){
			if($config instanceof IDataGroup){
				/** @var string|array */
				$path = $config->value(PAPConnectionConfig::PATH);
				if($path){
					if(is_array($path)){
						ClassLibrary::registerPathList($path);
					}else{
						ClassLibrary::registerPaths($path);
					}
				}
			}
			/** @var IPAPProtocolService */ $protocol = call_user_func(array($service, IPAPConnectionFactory::CREATE_INSTANCE_METHOD), $config);
			if($protocol && $protocol->isSupported()){
				return $protocol;
			}	
		}
		return DefaultProtocolService::getInstance(null);
	}
	static public function applyDefinedConnections(PAPConnectionsManager $manager, IDataGroup $group){
		/** @var IPAPProtocolService */
		$protocol = $manager->protocol();
		/** @var IPAPConnectionFactory[] */
		$factories = array();
		/** @var IPAPConnectionFactory */
		$factory = null;
		if($group->hasValue(PAPConnectionConfig::GROUP_CONNECTION)){
			/** @var string[] */
			$connections = $group->value(PAPConnectionConfig::GROUP_CONNECTION);
			if(!is_array($connections)){
				$connections = array($connections);
			}
			foreach($connections as /** @var string */ $factoryName){
				if($factoryName){
					$factory = call_user_func(array($factoryName, IPAPConnectionFactory::CREATE_INSTANCE_METHOD), null);
					if($factory){
						array_push($factories, $factory);
					}else{
						throw new Exception('PAPConnectionsManagerParser Error: Connection factory "'.$factoryName.'" was not created');
					}
				}else{
					throw new Exception('PAPConnectionsManagerParser Error: Required connection factory name must be set and must be not empty string');
				}
			}
		}
		if($group->hasGroup(PAPConnectionConfig::GROUP_CONNECTION)){
			/** @var IDataLeves */
			$levels = $group->group(PAPConnectionConfig::GROUP_CONNECTION);
			foreach($levels as /** @var IDataGroup */ $connection){
				if($connection->hasValue(PAPConnectionConfig::CONNECTION_FACTORY)){
					$factoryName = $connection->value(PAPConnectionConfig::CONNECTION_FACTORY);
				}
				if($factoryName){
					/** @var string|array */
					$path = $connection->value(PAPConnectionConfig::PATH);
					if($path){
						if(is_array($path)){
							ClassLibrary::registerPathList($path);
						}else{
							ClassLibrary::registerPaths($path);
						}
					}
					$factory = call_user_func(array($factoryName, IPAPConnectionFactory::CREATE_INSTANCE_METHOD), null);
					if($factory){
						array_push($factories, $factory);
					}else{
						throw new Exception('PAPConnectionsManagerParser Error: Connection factory "'.$factoryName.'" was not created');
					}
				}else{
					throw new Exception('PAPConnectionsManagerParser Error: Required connection factory name must be set and must be not empty string');
				}
			}
		}
		/** @var PAPLaunchersCollection */
		$launchers = $manager->launchers();
		/** @var PAPInspectorsCollection */
		$inspectors = $manager->inspectors();
		/** @var PAPConnectionsManagerHelpers */
		$helpers = $manager->helpers();
		$inspectorHelper = $helpers->inspector();
		$launcherHelper = $helpers->launcher();
		foreach($factories as $factory){
			if($factory->isSupported()){
				/** @var IPAPConnectionInspector */
				$inspector = $factory->getInspector($inspectorHelper);
				if($inspector){
					$inspectors->addInspector($inspector);
				}
				/** @var IPAPLauncher */
				$launcher = $factory->getLauncher($launcherHelper);
				if($launcher){
					$launchers->addLauncher($launcher);
				}
			}
		}
	}
}

?>