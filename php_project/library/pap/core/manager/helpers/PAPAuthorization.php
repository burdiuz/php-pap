<?php

/**
 * Check's authorization codes
 * @author Oleg
 *
 */
class PAPAuthorization extends NonDynamicObject {
	/**
	 * Module specific keys
	 * @var array
	 */
	private $_moduleKeys;
	/**
	 * Client specific keys
	 * @var array|null
	 */
	private $_clientKeys;
	/**
	 * Is authorization enabled. Enabled means that any of keys was passed(enabled).
	 * @var boolean
	 */
	private $_enabled;
	/**
	 * Shared keys
	 * @var array|null
	 */
	private $_shared;
	/**
	 * 
	 * @param array $sharedKeys
	 */
	public function __construct($sharedKeys=null){
		$this->_clientKeys = null;
		$this->_moduleKeys = array(PAPTrustLevel::HIGH=>null, PAPTrustLevel::MEDIUM=>null, PAPTrustLevel::LOW=>null, PAPTrustLevel::NONE=>null);
		if($sharedKeys && is_array($sharedKeys) && count($sharedKeys)){
			$this->_enabled = true;
			$this->_shared = $sharedKeys;
		}else{
			$this->_enabled = false;
			$this->_shared = null;
		}
	}
	/**
	 * Is connection type specific authorization defined. 
	 * @param string $connectionType
	 * @param int $trustLevel
	 * @return boolean
	 */
	public function isDefined($connectionType, $trustLevel=PAPTrustLevel::NONE){
		$defined = false;
		switch($connectionType){
			case PAPConnectionType::CLIENT:
				$defined = (boolean)$this->_clientKeys;
			break;
			case PAPConnectionType::MODULE:
				$defined = (boolean)$this->_moduleKeys[$trustLevel];
			break;
			default:
				throw new Exception('PAPConnectionAuthorization Error: Connection type "'.$connectionType.'" is not supported.');
			break;
		}
		return $defined ? true : (boolean)$this->_shared;
	}
	/**
	 * Add authorization keys for specific connection type and trust level.
	 * @param string $connectionType
	 * @param string[] $connectionKeys
	 * @param int $trustLevel
	 */
	public function define($connectionType, $connectionKeys, $trustLevel=PAPTrustLevel::NONE){
		if($connectionKeys){
			if(!is_array($connectionKeys)){
				$connectionKeys = array($connectionKeys);
			}
			$this->_enabled = true;
		}else{
			$connectionKeys = null;
		}
		switch($connectionType){
			case PAPConnectionType::CLIENT:
				$this->_clientKeys = $connectionKeys;
			break;
			case PAPConnectionType::MODULE:
				$this->_moduleKeys[$trustLevel] = $connectionKeys;
			break;
			default:
				throw new Exception('PAPConnectionAuthorization Error: Connection type "'.$connectionType.'" is not supported.');
			break;
		}
	}
	/**
	 * Check's authorization.
	 * @see PAPConnectionType
	 * @see PAPTrustLevel
	 * @param string $connectionType
	 * @param string[] $keys
	 * @param int $trustMode
	 * @return boolean
	 */
	public function authorize($connectionType, $connectionKeys, $trustLevel=PAPTrustLevel::NONE){
		$authKeys = null;
		if($connectionKeys){
			if(!is_array($connectionKeys)){
				$connectionKeys = array($connectionKeys);
			}
		}else{
			$connectionKeys = null;
		}
		switch($connectionType){
			case PAPConnectionType::CLIENT:
				$authKeys = $this->_clientKeys;
			break;
			case PAPConnectionType::MODULE:
				$authKeys = $this->_moduleKeys[$trustLevel];
			break;
			default:
				throw new Exception('PAPConnectionAuthorization Error: Connection type "'.$connectionType.'" is not supported.');
			break;
		}
		if(!$authKeys) $authKeys = $this->_shared;
		return $authKeys===$connectionKeys;
	}
	/**
	 * 
	 * Если для модуля не указаны ключи авторизации или указаны общие ключи, то используется следующая схема определения уровней доверия:
	 * 1. Если у него был сохранён ID, как доверенный
	 *	1. Если у него был конфиг papTrustedModule=1, то уровень доверия = HIGH
	 *	2. Если не было -- MEDIUM
	 * 2. Если ID не был сохранён, т.е. модуль был запущен самостоятельно 
	 *	1. Если у него был конфиг papTrustedModule=1, то уровень доверия = HIGH
	 *	2. Если не было -- LOW
	 * Если указан хотя-бы один специфический ключ, то действуют эти правила:
	 * Проверка ключей идёт от самого доверенного к недоверенному режиму, а для клиентов сразу недоверенный, единственный доступный для клиентов.
	 * Недоверенного уровня не существует ни для клиентов, ни для модулей, он обозначает, что клиент/модуль не прошёл авторизацию и вообще алень, минимальный -- LOW.
	 * 
	 * Searches for available trust mode by connection type and authorization keys.
	 * @param string $connectionType
	 * @param array $keys
	 * @param boolean $configTrusted Can be TRUE if config parameter "papTrustedModule"=1
	 * @param boolean $idConfirmed Only for modules, TRUE if module was launched from IPAPLauncher and it's ID was saved as trusted.
	 * @return int
	 * @see PAPConnectionType
	 */
	public function getTrustLevel($connectionType, $connectionKeys, $configTrusted=false, $idConfirmed=false){
		$level = PAPTrustLevel::NONE;
		switch($connectionType){
			case PAPConnectionType::CLIENT:
				if($this->authorize($connectionType, $connectionKeys)){
					$level = PAPTrustLevel::LOW;
				}
			break;
			case PAPConnectionType::MODULE:
				$list = PAPTrustLevel::getList();
				$wasDefined = false;
				foreach($list as /** @var int */$trustLevel){
					if($this->isDefined($connectionType, $trustLevel)){
						$wasDefined = true;
						if($this->authorize($connectionType, $connectionKeys, $trustLevel)){
							$level = $trustLevel;
							break;
						}
					}
				}
				if(!$wasDefined){
					if($this->hasShared()){
						if($this->authorize($connectionType, $connectionKeys)){
							$level = $configTrusted ? PAPTrustLevel::HIGH : PAPTrustLevel::MEDIUM;
						}
					}else{
						if($idConfirmed){
							$level = $configTrusted ? PAPTrustLevel::HIGH : PAPTrustLevel::MEDIUM;
						}else{
							$level = $configTrusted ? PAPTrustLevel::HIGH : PAPTrustLevel::LOW;
						}
					}
				}
			break;
			default:
				throw new Exception('PAPConnectionAuthorization Error: Connection type "'.$connectionType.'" is not supported.');
			break;
		}
		return $level;
	}
	/**
	 * Is authorization specified in config
	 * @return boolean
	 */
	public function isEnabled(){
		return $this->_enabled;
	}
	/**
	 * Is shared keys defined for modules and clients
	 * @return boolean
	 */
	public function hasShared(){
		return (boolean)$this->_shared;
	}
	public function __destruct(){
		$this->_moduleKeys = null;
		$this->_clientKeys = null;
		$this->_shared = null;
	}
	/**
	 * Create new instance using authorization config
	 * @param IDataGroup $config Authorization specific config group
	 * @return PAPAuthorization
	 */
	static public function getInstance(IDataGroup $config=null){
		/** @var PAPAuthorization */ $instance = null;
		if($config){
			if($config->hasValue(PAPAuthorizationConfig::KEY)){
				$keys = $config->value(PAPAuthorizationConfig::KEY);
				$instance = new PAPAuthorization(is_array($keys) ? $keys : array($keys));
			}else{
				$instance = new PAPAuthorization();
			}
			$types = array(PAPConnectionType::MODULE, PAPConnectionType::MODULE, PAPConnectionType::MODULE, PAPConnectionType::CLIENT);
			$groups = array(PAPAuthorizationConfig::GROUP_HIGH, PAPAuthorizationConfig::GROUP_MEDIUM, PAPAuthorizationConfig::GROUP_LOW, PAPAuthorizationConfig::GROUP_CLIENT);
			$levels = array(PAPTrustLevel::HIGH, PAPTrustLevel::MEDIUM, PAPTrustLevel::LOW, PAPTrustLevel::NONE);
			$count = count($groups);
			for($index=0; $index<$count; $index++){
				$name = $groups[$index];
				if($config->hasGroup($name)){
					/** @var IDataGroup */ $group = $config->group($name)->level(0);
					if($group->hasValue(PAPAuthorizationConfig::KEY)){
						$keys = $group->value(PAPAuthorizationConfig::KEY);
						$instance->define($types[$index], $keys, $levels[$index]);
					}
				}else if($config->hasValue($name)){
					$keys = array($config->value($name));
					$instance->define($types[$index], $keys, $levels[$index]);
				}
			}
		}else{
			$instance = new PAPAuthorization();
		}
		return $instance;
	}
}

?>