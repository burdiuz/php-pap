<?php

class ArgumentsCallback extends SingleValueCallback{
	static private $_index = 0;
	static private $_count = 0;
	public function __callback($value){
		$this->value = func_get_args();
	}
	public function getData(){
		return $this->value;
	}
	static private $_createdIndex = array();
	/**
	 * 
	 * @param array $list List of string names
	 * @return ArgumentsCallback
	 */
	static public function customArgumentList($list){
		$name = 'ArgumentsCallback';
		$count = count($list);
		if($list && $count){
			$defineSection = '';
			$applySection = '';
			for($index=0; $index<$count; $index++){
				$value = ltrim($list[$index], '$');
				$list[$index] = $value;
				$defineSection .= 'public $'.$value.';';
				$applySection .= '$this->'.$value.' = $'.$value.';';
			}
			$name = 'ArgumentsCallback_'.$count.'_'.implode('_', $list);
			if(!isset(self::$_createdIndex[$name])){
				eval('final class '.$name.' extends AbstractCallback{'.$defineSection.'public function __construct(){parent::__construct();}public function __callback($'.implode(', $', $list).'){'.$applySection.'}}');
			}
		}
		return new $name();
	}
	static private $_createdCount = array();
	/**
	 * 
	 * @param int $count Arguments count
	 * @return ArgumentsCallback
	 */
	static public function customArgumentCount($count){
		$count = (int)$count;
		if($count<=0){
			$name = 'ArgumentsCallback';
		}else{
			$name = 'ArgumentsCallback_count_'.(self::$_count++);
			if(!isset(self::$_createdCount[$count])){
				$list = array();
				while($count){
					$count--;
					$list[$count] = '$a'.$count;
				}
				$list = implode(',', $list);
				eval('final class '.$name.' extends AbstractCallback{public $value;public function __construct(){parent::__construct();}public function __callback('.$list.'){$this->value = array('.$list.');}}');
				self::$_createdCount[$count] = true;
			}
		}
		return new $name();
	}
}
?>