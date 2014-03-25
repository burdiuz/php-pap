<?php

/**
 * 
 * @author iFrame
 *
 
$id = 'module/123-456';
/** @var PAPModuleCommand * /
$command = new PAPModuleCommand(null, 'test_module', 0, '/modules/test_module.php', array('go_online'=>true, 'some_param'=>'hello'), null);
/** @var PAPSocketConnectionConfig * /
$config = new PAPSocketConnectionConfig();
$config->wrapperPath = '/wrapper.php';
$method = new PAPSocketLauncherMethod_fopen($config);
/** @var PAPSocketLauncherHandler * /
$handler = $method->write($id, $command);
for($i=0; $i<10; $i++){
	if($handler->isFinished()) break;
	$method->read($handler);
	usleep(250000);
}
echo '<br><br>'.$handler->output;

 */
class PAPSocketLauncherMethod_fopen extends PAPSocketLauncherMethod {
	public function write($id, PAPModuleCommand $command){
		//$agent = ini_get('user_agent');
		//ini_set('user_agent', $this->_config->userAgent);
		$data = $this->serializeConfig($command);
		$path = $this->generateWrapperURL($command->parameters());
		$context = stream_context_create(
			array(
				'http'=>array(
					'method'=>'POST',
					'header'=>$this->generateHeaders($data, false),
					'content'=>$data
				)
			)
		);
		$file = fopen($path, 'r', false, $context);
		//ini_set('user_agent', $agent);
		if(is_resource($file)){
			stream_set_blocking($file, 0);
			stream_set_read_buffer($file, $this->_config->bufferLength);
			return new PAPSocketLauncherHandler($id, $command, $file);
		}
		return false;
	}
	public function read(PAPSocketLauncherHandler $handler){
		if($handler->isFinished()) return;
		$file = $handler->handler;
		if($handler->hasHandler() && !feof($file)){
			$data = stream_get_contents($file);
			echo "has handler<br>";
			$this->updateHandler($handler, $data);
			if(feof($file)) $this->finish($handler);
		}else{
			echo "NO handler OR feof! ".feof($file)."<br>";
			$this->finish($handler);
		}
	}
	public function finish(PAPSocketLauncherHandler $handler){
		if($handler->handler){
			fclose($handler->handler);
			$handler->handler = null;
		}
		parent::finish($handler);
	}
}

?>