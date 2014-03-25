<?php

/**
 * Класс контроля вывода, позволяет предотвращать нежелательный вывод с помощью установки подавляемого буффера.
 * @author Oleg
 *
 */
final class Output{
	/**
	 * Функция обратного вызова, использующася для отчистки данных попадаемых в буффер
	 * @var Output_callbackHandler
	 */
	static private $_callback;
	/**
	 * Флаг инициализации
	 * @var boolean
	 */
	static private $_initialized;
	/**
	 * Флаг включения
	 * @var boolean
	 */
	static private $_enabled;
	/**
	 * Ресурс вывода
	 * @var resource
	 */
	static private $_handler;
	/**
	 * Включить подавляющую буфферизацию вывода
	 * @throws Exception Если не удалось включить буфферизацию вывода
	 */
	static private function turn_On(){
		if(self::$_enabled){
			if(!ob_start(self::$_callback->handler, 1, true)){
				throw new Exception('Output Error: Cannot initialize output buffering.');
			}
		}
	}
	/**
	 * Отключить любую буфферизацию вывода
	 * @param unknown_type $force Если TRUE, то выполнится даже если enabled=false
	 */
	static private function turn_Off($force=false){
		if(self::$_enabled || $force){
			$count = ob_get_level();
			while($count--) ob_end_clean();
		}
	}
	/**
	 * Подавляется ли вывод
	 * @return boolean
	 */
	static public function isEnabled(){
		return self::$_enabled;
	}
	/**
	 * Включить подавление
	 */
	static public function enable(IOutputDestination $destination=null){
		if(!self::$_initialized){
			self::turn_Off();
			self::$_callback = new Output_callbackHandler();
			if(!$destination){
				self::$_callback->destination = new OutputNullDestination();
			}
			self::$_handler = fopen('php://output', 'w');
			self::$_initialized = true;
		}
		if($destination){
			self::$_callback->destination = $destination;
		}
		self::$_enabled = true;
		self::$_callback->enabled = true;
		self::turn_On();
	}
	/**
	 * Отключить подавление
	 */
	static public function disable(){
		self::turn_Off(true);
		self::$_enabled = false;
		self::$_callback->enabled = false;
	}
	/**
	 * Отправить на вывод любую информацию
	 * @param any $output
	 */
	static public function write($output){
		self::turn_Off();
		$arguments = func_get_args();
		foreach($arguments as $argument){
			fwrite(self::$_handler, (string)$argument);
		}
		self::turn_On();
	}
}

/**
 * Класс содержит функцию обратного вызова для 
 * @author Oleg
 * @private
 */
class Output_callbackHandler extends NonDynamicObject{
	const OUTPUT_HANDLER = 'outputHandler';
	public $enabled;
	/**
	 * 
	 * @var array
	 */
	public $handler;
	/**
	 * Output destination while buffer enabled
	 * @var IOutputDestination
	 */
	public $destination;
	public function __construct(){
		$this->handler = array($this, self::OUTPUT_HANDLER);
	}
	public function outputHandler(){
		$value = (string)func_get_args();
		if($this->enabled){
			$this->destination->write($value);
		}
		return $value;
	}
}
?>