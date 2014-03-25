<?php
abstract class NonDynamicObject {
	public function __get($name){
		throw new Exception('NonDynamicObject Error: Access to dynamic fields prohibited, tried "'.$name.'" in "'.get_class($this).'".');
	}
	public function __set($name, $value){
		throw new Exception('NonDynamicObject Error: Creation of dynamic fields prohibited.');
	}
	public function __call($name, $arguments){
		throw new Exception('NonDynamicObject Error: Calling of dynamic fields prohibited.');
	}
	public function __isset($name){
		return false;
	}
	public function __toString(){
		return $this->formatString(array());
	}
	public function formatString($args){
		$strings = array();
		foreach($args as $key=>$value){
			$value = $this->$value;
			if(is_bool($value)){
				$value = $value ? 'true' : 'false';
			}else{
				$value = addslashes($value);
			}
			array_push($strings, $key.'="'.$value.'"');
		}
		return '['.get_class($this).'('.implode(', ', $strings).')]';
	}
}

?>