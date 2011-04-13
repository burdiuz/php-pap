<?php

class ExecutableHash extends ExecutableCollection implements IExecutableHash{
	public function addItemByKey($key, IExecutable $item){
		if($this->checkOverwriteOption((string)$key)){
			$this->_items->value[(string)$key] = $item;
			return true;
		}
		return false;
	}
	public function getItemByKey($key){
		return isset($this->_items->value[(string)$key]) ? $this->_items->value[(string)$key] : null;
	}
	public function removeItem(IExecutable $item){
		$key = $this->getKey($item);
		if($key===false) return false;
		unset($this->_items->value[$key]);
		return $key;
	}
	public function removeItemByKey($key){
		$value = isset($this->_items->value[$key]);
		unset($this->_items->value[$key]);
		return $key;
	}
	public function getKey(IExecutable $item){
		return array_search($item, $this->_items->value, true);
	}
	public function hasKey($key){
		return isset($this->_items->value[$key]);
	}
}

?>