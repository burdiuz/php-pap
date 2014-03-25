<?php
#@import PAPSocketLauncherMethod_fopen
#@import PAPSocketLauncherMethod_fsockopen
#@import PAPSocketLauncherMethod_cURL
#@import PAPSocketLauncherMethod_socket
/*
 * Надо подумать, это будет реюзабельный объект или один на одно соединение.
 * Если реюзабельный:
 * Каждый такой метод создаёт соединение с враппером по ID модуля и считывает тоже по ID.
 */
abstract class PAPSocketLauncherMethod extends NonDynamicObject implements IPAPSocketLauncherMethod{
	const RN = "\r\n";
	const METHOD_FOPEN = 'fopen';
	const METHOD_FSOCKOPEN = 'fsockopen';
	const METHOD_CURL = 'curl';
	const METHOD_SOCKET = 'socket';
	static private $methods = array(
		self::METHOD_FOPEN => 'PAPSocketLauncherMethod_fopen', 
		self::METHOD_FSOCKOPEN => 'PAPSocketLauncherMethod_fsockopen', 
		self::METHOD_CURL => 'PAPSocketLauncherMethod_cURL', 
		self::METHOD_SOCKET => 'PAPSocketLauncherMethod_socket'
	);
	/**
	 * 
	 * @var PAPSocketConnectionConfig
	 */
	protected $_config;
	/**
	 * 
	 * @var array
	 */
	protected $_parameters;
	public function __construct(PAPSocketConnectionConfig $config, $parameters=array()){
		$this->_config = $config;
		$this->_parameters = is_array($parameters) ? $parameters : array();
	}
	public function write($id, PAPModuleCommand $command){
		return new PAPSocketLauncherHandler($id, $command);
	}
	protected function generatePOST($parameters, $data='', $version='1.1'){
		if(!$parameters) $parameters = array();
		foreach($this->_parameters as $key=>$value){
			$parameters[$key] = $value;
		}
		return 'POST '.$this->_config->wrapperPath.'?'.http_build_query($parameters).' HTTP/'.$version.self::RN.$this->generateHeaders($data, true);
	}
	protected function generateWrapperPath($parameters){
		if(!$parameters) $parameters = array();
		foreach($this->_parameters as $key=>$value){
			$parameters[$key] = $value;
		}
		return $this->_config->wrapperPath.'?'.http_build_query($parameters);
	}
	protected function generateWrapperURL($parameters){
		$path = 'http://'.$this->_config->wrapperHost;
		$port = $this->_config->wrapperPort;
		if($port) $path .= ':'.$port;
		return $path.$this->generateWrapperPath($parameters);
	}
	protected function generateHeaders($data, $includeBody=false){
		return 
		'Host: '.$this->_config->wrapperHost.self::RN.
		'User-Agent: '.$this->_config->userAgent.self::RN.
		'Content-length: '.strlen($data).self::RN.
		'Content-type: application/x-www-form-urlencoded'.self::RN.
		'Connection: close'.self::RN.
		($includeBody ? self::RN.$data : '');
	}
	protected function serializeConfig(PAPModuleCommand $command){
		return urlencode(serialize($command->config()));
	}
	public function read(PAPSocketLauncherHandler $handler){
		$this->finish($handler);
	}
	public function finish(PAPSocketLauncherHandler $handler){
		$handler->setFinished();
	}
	protected function updateHandler(PAPSocketLauncherHandler $handler, $data){
		if(strlen($data)){
			$handler->appendOutput($data);
			$handler->updateTimeout();
		}else if($handler->isTimedOut($this->_config->wrapperResponseTimeout)){
			$this->finish($handler);
		}
	}
	static public function getInstance(PAPSocketConnectionConfig $config, $method=self::METHOD_FOPEN){
		/** @var string */
		$class = isset(self::$methods[$method]) ? self::$methods[$method] : self::$methods[self::METHOD_FOPEN];
		return new $class($config);
	}
	static public function registerMethod($name, $definition){
		if($name && $definition){
			self::$methods[$name] = $definition;
		}else{
			throw new Exception('PAPSocketLauncherMethod Error: Registered method must have name and definition class');
		}
	}
	static public function getSupportedMethod(){
		$method = null;
		if(ini_get('allow_url_fopen')){
			$method = self::METHOD_FOPEN;
		}else if(function_exists('fsockopen')){
			$method = self::METHOD_FSOCKOPEN;
		}else if(function_exists('curl_init')){
			$method = self::METHOD_CURL;
		}else if(function_exists('socket_create')){
			$method = self::METHOD_SOCKET;
		}else{
			throw new Exception('PAPSocketLauncher Error: All known methods to launch modules disabled.');
		}
		return $method;
	}
}

?>