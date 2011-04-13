<?php
class ErrorHandler {
	static private $catchable = array(E_ERROR, E_WARNING, E_NOTICE, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_STRICT, E_RECOVERABLE_ERROR/*, E_DEPRECATED, E_USER_DEPRECATED*/);
	static private $errors = array();
	static private $counters = array();
	static private $currentLevel = 0;
	static public $displayErrors = true;
	static public function initialize(){
		self::setLevel(E_ALL);
	}
	static public function setLevel($level){
		restore_error_handler();
		set_error_handler('ErrorHandler::_errorHandler', $level);
		self::$currentLevel = $level;
	}
	static public function get($level){
		$array = array();
		foreach(self::$catchable as $value){
			if($level&$value && isset(self::$errors[$value])){
				array_merge($array, self::$errors[$value]);
			}
		}
		return $array;
	}
	static public function count($level){
		$count = 0;
		foreach(self::$catchable as $value){
			if($level&$value && isset(self::$errors[$value])){
				$count += count(self::$errors[$value]);
			}
		}
		return $count;
	}
	static public function getCounter($level=E_ALL){
		$counter = new ErrorCounter($level);
		foreach(self::$catchable as $value){
			if($level&$value){
				if(!isset(self::$counters[$value])){
					self::$counters[$value] = array();
				}
				array_push(self::$counters[$value], $counter);
			}
		}
		return $counter;
	}
	static public function removeCounter(ErrorCounter $counter){
		$level = $counter->getLevel();
		foreach(self::$catchable as $value){
			if($level&$value && in_array($counter, self::$counters[$value])){
				$index = array_search($counter, self::$counters[$value]);
				array_splice(self::$counters[$value], $index, 1);
			}
		}
	}
	static public function removeAllCounters($level=E_ALL){
		foreach(self::$catchable as $value){
			if($level&$value && isset(self::$counters[$value])){
				unset(self::$counters[$value]);
			}
		}
	}
	static public function _errorHandler($errno, $errstr, $errfile, $errline, $errcontext){
		$error = new ErrorInfo($errno, $errstr, $errfile, $errline, $errcontext);
		if(!isset(self::$errors[$errno])) self::$errors[$errno] = array();
		array_push(self::$errors[$errno], $error);
		if(isset(self::$counters[$errno])){
			foreach(self::$counters[$errno] as $counter){
				$counter->_count();
			}
		}
		if(self::$displayErrors){
			echo $error;
		}
	}
	static public function clear($level=E_ALL){
		foreach(self::$catchable as $value){
			if($level&$value && isset(self::$errors[$value])){
				unset(self::$errors[$value]);
			}
		}
	}
	static public function levelToString($level){
		$string = 'UNKNOWN';
		switch($level){
			case E_ERROR:
			case E_RECOVERABLE_ERROR:
			case E_USER_ERROR:
				$string = 'ERROR';
			break;
			case E_WARNING:
			case E_USER_WARNING:
				$string = 'WARNING';
			break;
			case E_NOTICE:
			case E_DEPRECATED:
			case E_USER_NOTICE:
			case E_USER_DEPRECATED:
				$string = 'NOTICE';
			break;
		}
		return $string;
	}
}
class ErrorInfo{
	public $errno;
	public $errstr;
	public $errfile;
	public $errline;
	public $errcontext;
	public function __construct($errno, $errstr, $errfile, $errline, $errcontext){
		$this->errno = $errno;
		$this->errstr = $errstr;
		$this->errfile = $errfile;
		$this->errline = $errline;
		$this->errcontext = $errcontext;
	}
	public function __toString(){
		return '<b>'.ErrorHandler::levelToString($this->errno)."</b> [$this->errno] $this->errstr<br />\n";
	}
}
class ErrorCounter{
	private $level = 0;
	private $value = 0;
	public function __construct($level){
		$this->level = $level;
	}
	public function getLevel(){
		return $this->level;
	}
	public function getValue(){
		return $this->value;
	}
	public function _count(){
		$this->value++;
	}
	public function __toString(){
		return ErrorHandler::levelToString($this->level)."($this->value)";
	}
}
?>