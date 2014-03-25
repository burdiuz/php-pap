<?php
class ClassLibrary {
	const NS_SPACER = '\\';
	const PATH_SPACER = '/';
	static private $_initialized;
	static private $_paths = array();
	static private $_pathsCount = 0;
	static private $_delimiter = ':';
	static public function initialize($register=true){
		if(self::$_initialized) throw new Exception('ClassLibrary Error: Already initialized.');
		if(stripos(getenv('OS'), 'windows')!==false){
			self::$_delimiter = ';';
		}
		$args = func_get_args();
		if(count($args)){
			self::registerPathList($args);
		}
		self::$_initialized = true;
		if($register){
			spl_autoload_register('ClassLibrary::loadClass');
		}
	}
	static public function isInitialized(){
		return self::$_initialized;
	}
	static public function registerPaths($path){
		self::registerPathList(func_get_args());
	}
	static public function registerPathList($list=array()){
		$paths = explode(self::$_delimiter, get_include_path());
		self::$_paths = array_merge(self::$_paths, $list);
		self::$_pathsCount = count(self::$_paths);
		set_include_path(implode(self::$_delimiter, array_merge($paths, $list)));
	}
	static public function registerRecursive($path){
		$path = realpath($path);
		if(is_dir($path)){
			$list = self::__registerRecursive($path, array());
			self::registerPathList($list);
		}
	}
	static private function __registerRecursive($path, $list){
		array_push($list, $path);
		$folder = opendir($path);
		while(($item = readdir($folder))!==false){
			if($item[0]=='.') continue;
			$item = $path.self::PATH_SPACER.$item;
			if(is_dir($item)){
				$list = self::__registerRecursive($item, $list);
			}
		}
		closedir($folder);
		return $list;
	}
	static public function loadClass($class){
		if(strpos($class, self::NS_SPACER)!==false){
			if(!self::loadClassByQualifiedName($class)){
				$nsList = explode(self::NS_SPACER, $class);
				$class = array_pop($nsList);
			}
		}
		$file = $class.'.php';
		$counter = ErrorHandler::getCounter(E_WARNING);
		include_once $file;
		ErrorHandler::removeCounter($counter);
		if($counter->getValue()){
			return self::manualLoadClass($class);
		}
		return true;
	}
	static private function loadClassByQualifiedName($class){
		$file = str_replace(self::NS_SPACER, self::PATH_SPACER, ltrim($class, self::NS_SPACER)).'.php';
		$counter = ErrorHandler::getCounter(E_WARNING);
		include_once $file;
		ErrorHandler::removeCounter($counter);
		if($counter->getValue()){
			return false;
		}
		return true;
	}
	static public function manualLoadClass($class){
		$file = $class.'.php';
		for($index=0; $index<self::$_pathsCount; $index++){
			$path = self::$_paths[$index].'/'.$file;
			if(file_exists($path)){
				require_once $path;
				return true;
			}
		}
		return false;
	}
}
?>