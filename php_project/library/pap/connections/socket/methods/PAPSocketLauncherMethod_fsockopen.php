<?php

class PAPSocketLauncherMethod_fsockopen extends PAPSocketLauncherMethod_fopen{
	const FSOCKOPEN_TIMEOUT = 'fsockopenTimeout';
	const DEFAULT_FSOCKOPEN_TIMEOUT = 50;
	private $_timeout;
	public function __construct(PAPSocketConnectionConfig $config, $parameters=array()){
		parent::__construct($config, $parameters);
		$this->_timeout = ($config->rawConfig ? $config->rawConfig->value(self::FSOCKOPEN_TIMEOUT, self::DEFAULT_FSOCKOPEN_TIMEOUT) : self::DEFAULT_FSOCKOPEN_TIMEOUT)*1000;
	}
	public function write($id, PAPModuleCommand $command){
		$file = fsockopen($this->_config->wrapperHost, $this->_config->wrapperPort, $errno, $errstr, $this->_timeout);
		if(is_resource($file) && !$errno){
			$data = $this->serializeConfig($command);
			fwrite($file, $this->generatePOST($command->parameters(), $data, '1.0')); // HTTP version 1.0 will disable Chunked transfer encoding
			usleep($this->_timeout);
			socket_set_blocking($file, FALSE);
			stream_set_read_buffer($file, $this->_config->bufferLength);
			return new PAPSocketLauncherHandler($id, $command, $file);
		}
		return false;
	}
	public function finish(PAPSocketLauncherHandler $handler){
		/** @var string */
		$output = $handler->output;
		$needle = PAPSocketLauncherMethod::RN.PAPSocketLauncherMethod::RN;
		/** @var int|false */
		$index = strpos($output, $needle);
		if($index!==false){
			$handler->output = substr($output, $index+strlen($index));
		}
		parent::finish($handler);
	}
}
?>