<?php

class PAPUtils {
	const ATTR_CLIENT_INITIATED = 'client-initiated';
	const ATTR_CONFIG = 'config';
	static private $_moduleIndex = 0;
	static private $_entityIndex = 0;
	static public function getOptions(){
		return getopt('', array(self::ATTR_CLIENT_INITIATED.'::', self::ATTR_CONFIG.':'));
	}
	static public function packData($data, $chr=null){
		return addcslashes(serialize($data), (is_null($chr) ? chr(0) : $chr).'\\');
	}
	static public function unpackData($data){
		return unserialize(stripcslashes($data));
	}
	static public function protectString($data, $chr=null){
		return addcslashes($data, (is_null($chr) ? chr(0) : $chr).'\\');
	}
	static public function unprotectString($data){
		return stripcslashes($data);
	}
	static public function isWindowsOS(){
		return strtoupper(substr(PHP_OS, 0, 3))=='WIN';
	}
	static public function getValueByOS($ifWindows, $ifUnix){
		return self::isWindowsOS() ? $ifWindows : $ifUnix;
	}
	static public function getUniqueModuleId($name){
		return urlencode($name).'/'.(++self::$_moduleIndex).'-'.microtime(true);
	}
	static public function getUniqueEntityId($type){
		return $type.'/'.(++self::$_entityIndex).'-'.microtime(true);
	}
}

?>