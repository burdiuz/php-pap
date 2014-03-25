<?php

/**
 * Allowed parameters and default values for "connection" config group. 
 * @author iFrame
 *
 */
class PAPSocketConnectionConfig {
	/**
	 * Connection name that used to identify connection type.
	 * @var string
	 */
	const DEFAULT_NAME = 'socket';
	/**
	 * Unix socket path config parameter
	 * @var string
	 */
	const UNIX_PATH = 'unixPath';
	/**
	 * Host config parameter
	 * @var string
	 */
	const HOST = 'host';
	/**
	 * Port config parameter
	 * @var string
	 */
	const PORT = 'port';
	/**
	 * Maximum iunbound connections config parameter
	 * @var string
	 */
	const MAX_INBOUND_CONNECTIONS = 'maxInboundConnections';
	/**
	 * Buffer length config parameter
	 * @var string
	 */
	const BUFFER_LENGTH = 'bufferLength';
	const PREFFERED_METHOD = 'prefferedMethod';
	const USER_AGENT = 'userAgent';
	const WRAPPER_HOST = 'wrapperHost';
	const WRAPPER_ADDRESS = 'wrapperAddress';
	const WRAPPER_PATH = 'wrapperPath';
	const WRAPPER_PORT = 'wrapperPort';
	/**
	 * Maximum amount of time while application will wait for response from wrapper in milliseconds
	 * @var string
	 */
	const WRAPPER_RESPONSE_TIMEOUT = 'wrapperResponseTimeout';
	/**
	 * Default Unix socket file path
	 * @var string
	 */
	const DEFAULT_UNIX_PATH = '/tmp/php.pap.sock';
	/**
	 * Default host value
	 * @var string
	 */
	const DEFAULT_HOST = '127.0.0.1';
	/**
	 * Default port value
	 * @var string
	 */
	const DEFAULT_PORT = 3301;
	/**
	 * Default value of maximum incoming connections, zero by default means that connections count is not bound to any value.
	 * @var string
	 */
	const DEFAULT_MAX_INBOUND_CONNECTIONS = 0;
	/**
	 * Maximum read buffer size, 32 KBytes by default
	 * @var int
	 */
	const DEFAULT_BUFFER_LENGTH = 32768;
	const DEFAULT_USER_AGENT = 'PAP Module launcher';
	const DEFAULT_WRAPPER_PORT = '80';
	const DEFAULT_WRAPPER_RESPONSE_TIMEOUT = 500;
	/**
	 * @var string
	 */
	public $name;
	/**
	 * @var string
	 */
	public $unixPath;
	/**
	 * @var string
	 */
	public $host;
	/**
	 * @var string
	 */
	public $port;
	/**
	 * @var int
	 */
	public $bufferLength;
	/**
	 * @var int
	 */
	public $maxInboundConnections;
	/**
	 * @var string
	 */
	public $prefferedMethod;
	/**
	 * @var string
	 */
	public $userAgent;
	/**
	 * @var string
	 */
	public $wrapperHost;
	/**
	 * @var string
	 */
	public $wrapperAddress;
	/**
	 * @var string
	 */
	public $wrapperPath;
	/**
	 * @var string
	 */
	public $wrapperPort;
	/**
	 * @var string
	 */
	public $wrapperResponseTimeout;
	/**
	 * @var IDataGroup
	 */
	public $rawConfig;
	public function __construct(IDataGroup $config=null){
		$this->readConfig($config);
	}
	private function readConfig(IDataGroup $config=null){
		$this->wrapperHost = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $this->host;
		$this->wrapperAddress = $_SERVER['SERVER_ADDR'];
		if($config){
			$this->name = $config->value(PAPConnectionConfig::NAME, self::DEFAULT_NAME);
			$this->unixPath = $config->value(self::UNIX_PATH, self::DEFAULT_UNIX_PATH);
			$this->host = $config->value(self::HOST, self::DEFAULT_HOST);
			$this->port = $config->value(self::PORT, self::DEFAULT_PORT);
			$this->bufferLength = $config->value(self::BUFFER_LENGTH, self::DEFAULT_BUFFER_LENGTH);
			$this->maxInboundConnections = $config->value(self::MAX_INBOUND_CONNECTIONS, self::DEFAULT_MAX_INBOUND_CONNECTIONS);
			$this->userAgent = $config->value(self::USER_AGENT, self::DEFAULT_USER_AGENT);
			if($config->hasValue(self::PREFFERED_METHOD)){
				$this->prefferedMethod = $config->value(self::PREFFERED_METHOD);
			}
			$this->wrapperHost = $config->value(self::WRAPPER_HOST, $this->wrapperHost);
			$this->wrapperAddress = $config->value(self::WRAPPER_ADDRESS, $this->wrapperAddress);
			$this->wrapperPath = $config->value(self::WRAPPER_PATH, null);
			$this->wrapperPort = $config->value(self::WRAPPER_PORT, self::DEFAULT_WRAPPER_PORT);
			$this->wrapperResponseTimeout = $config->value(self::WRAPPER_RESPONSE_TIMEOUT, self::DEFAULT_WRAPPER_RESPONSE_TIMEOUT);
		}else{
			$this->name = self::DEFAULT_NAME;
			$this->unixPath = self::DEFAULT_UNIX_PATH;
			$this->host = self::DEFAULT_HOST;
			$this->port = self::DEFAULT_PORT;
			$this->bufferLength = self::DEFAULT_BUFFER_LENGTH;
			$this->maxInboundConnections = self::DEFAULT_MAX_INBOUND_CONNECTIONS;
			$this->userAgent = self::DEFAULT_USER_AGENT;
			$this->wrapperPath = null;
			$this->wrapperPort = self::DEFAULT_WRAPPER_PORT;
			$this->wrapperResponseTimeout = self::DEFAULT_WRAPPER_RESPONSE_TIMEOUT;
		}
		$this->wrapperResponseTimeout /= 1000; // will convert miliseconds value into seconds
		$this->rawConfig = $config;
	}
}

?>