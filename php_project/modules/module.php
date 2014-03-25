<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
if(!count(get_included_files())){
	define('PAP_LIBRARY_PATH', '../library/');
	require_once PAP_LIBRARY_PATH.'ErrorHandler.php';
	require_once PAP_LIBRARY_PATH.'ClassLibrary.php';
	ClassLibrary::initialize();
	ClassLibrary::registerRecursive(PAP_LIBRARY_PATH);
}
$module = new PAPModule();
print_r($_GLOBALS);

?>