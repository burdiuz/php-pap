<?php

class PAPSocketLauncherMethod_cURL extends PAPSocketLauncherMethod {
	public function write($id, PAPModuleCommand $command){
		$mh = curl_multi_init();
		$ch = curl_init($this->generateWrapperURL($command->parameters()));
		curl_multi_add_handle($mh, $ch);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_VERBOSE, 1);
		//curl_setopt($ch, CURLOPT_STDERR, fopen('curl.txt', 'w+'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->serializeConfig($command));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));
		//curl_setopt($ch, CURLOPT_URL, $this->generateWrapperURL($command->parameters()));
		curl_setopt($ch, CURLOPT_USERAGENT, $this->_config->userAgent);
		curl_multi_exec($mh, $used);
		$errno = curl_errno($ch);
		if(!$errno){
			return new PAPSocketLauncherHandler($id, $command, $ch, $mh);
		}
		return false;
	}
	public function read(PAPSocketLauncherHandler $handler){
		/** @var resource */
		$mh = $handler->options;
		/** @var resource */
		$ch = $handler->handler;
		$used = false;
		if(is_resource($mh) && is_resource($ch)){
			$ret = curl_multi_exec($mh, $used);
			if(!$used){
				$this->updateHandler($handler, curl_multi_getcontent($ch));
				$this->finish($handler);
			}
		}else{
			$this->finish($handler);
		}
	}
	public function finish(PAPSocketLauncherHandler $handler){
		/** @var resource */
		$mh = $handler->options;
		/** @var resource */
		$ch = $handler->handler;
		if(is_resource($mh) && is_resource($ch)){
			curl_multi_remove_handle($mh, $ch);
			curl_multi_close($mh);
			curl_close($ch);
			$handler->options = null;
		}
		parent::finish($handler);
	}
}

?>