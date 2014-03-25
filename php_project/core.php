<?php

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

define('PAP_LIBRARY_PATH', './library/');

require_once PAP_LIBRARY_PATH.'ErrorHandler.php';
require_once PAP_LIBRARY_PATH.'ClassLibrary.php';

ClassLibrary::initialize();
ClassLibrary::registerRecursive(PAP_LIBRARY_PATH);

$_GET['configFile'] = 'config.xml';
PAPConfig::readInput();
//file_put_contents('core.log', print_r(PAPModulesDictionary::getInstance(PAPConfig::getGlobal()->group(PAPConfigGroups::CORE)->group(PAPConfigGroups::MODULES)->level(0)), true));
//file_put_contents('core.log', print_r(PAPConnectionAuthorization::getInstance(PAPConfig::getGlobal()->group(PAPConfigGroups::CORE)->group(PAPConfigGroups::AUTHORIZATION)->level(0)), true));
PAPCore::initialize();
echo memory_get_usage()." : ".memory_get_usage(true);
exit;
PAPCore::instance()->start();
