<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

require_once 'library/ErrorHandler.php';
require_once 'library/ClassLibrary.php';
ClassLibrary::initialize();
ClassLibrary::registerRecursive('library');

Output::enable();
$status = new PAPModuleLaunchStatus('module/id-1', PAPModuleLaunchStatus::RAW_OUTPUT, new Exception('Something goes wrong!'));
Output::write($status);
//Output::disable();
$service = new DefaultProtocolService();
$list = $service->writeTransport('transport-1', 'module-2', array(
	new PAPProtocolPacket('packet-1', 'module-1', 1, 'test', array(1,2,3,4,5), time()), 
	new PAPProtocolPacket('packet-2', 'module-1', 1, 'test', array(1,2,3,4,5), time()), 
	new PAPProtocolPacket('packet-3', 'module-1', 1, 'test', array(1,2,3,4,5), time()), 
	new PAPProtocolPacket('packet-4', 'module-1', 1, 'test', array(1,2,3,4,5), time()), 
	new PAPProtocolPacket('packet-5', 'module-1', 1, 'test', array(1,2,3,4,5), time()), 
	new PAPProtocolPacket('packet-6', 'module-1', 1, 'test', array(1,2,3,4,5), time()), 
	new PAPProtocolPacket('packet-7', 'module-1', 1, 'test', array(1,2,3,4,5), time()), 
	new PAPProtocolPacket('packet-8', 'module-1', 1, 'test', array(1,2,3,4,5), time()), 
	new PAPProtocolPacket('packet-9', 'module-1', 1, 'test', array(1,2,3,4,5), time())
), false);
echo strlen($list[0])."\r\n";
echo $list[0];
$transport = $service->readTransport($list[0]);
print_r($transport);
$entities = $service->readEntities($transport[0]);
print_r($entities);
exit;

$file = fopen('log.txt', 'w+t');
fclose($file);
ob_implicit_flush();
function save_log($text){
	$file = fopen('log.txt', 'a+t');
	fwrite($file, $text."\r\n", strlen($text)+2);
	fclose($file);
	echo $text.'<br>';
}
function save_error($errno, $errmsg){
	$file = fopen('log.txt', 'a+t');
	$text = $errno.', '.$errmsg;
	fwrite($file, $text."\r\n", strlen($text)+2);
	fclose($file);
	echo $text.'<br>';
}
//set_error_handler('save_error', E_ALL);
/*
$pipes = array();
echo proc_open('php -f ./core.php -- --client-initiated=true', array(0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w")), $pipes, 'z:\home\localhost\www\paf\php_project').'<br>';
print_r($pipes);
//*/

?>