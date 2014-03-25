<?php

class PAPSocketLauncherMethod_socket extends PAPSocketLauncherMethod {
	public function write($id, PAPModuleCommand $command){
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if(is_resource($socket) && socket_connect($socket, $this->_config->wrapperAddress, $this->_config->wrapperPort)!==false){
			$data = $this->generatePOST($command->parameters(), $this->serializeConfig($command), '1.0');
			socket_write($socket, $data, strlen($data));
			return new PAPSocketLauncherHandler($id, $command, $socket);
		}
		return false;
	}
	public function read(PAPSocketLauncherHandler $handler){
		if($handler->isFinished()) return;
		$socket = $handler->handler;
		$data = '';
		if($handler->hasHandler() && false!==socket_recv($socket, $data, 2048, MSG_WAITALL)){
			$this->updateHandler($handler, $data);
		}else{
			$this->finish($handler);
		}
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
		if($handler->handler){
			socket_shutdown($handler->handler, 2);
			socket_close($handler->handler);
			$handler->handler = null;
		}
		parent::finish($handler);
	}
}

?>