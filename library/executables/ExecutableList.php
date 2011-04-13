<?php

class ExecutableList extends ExecutableCollection{
	public function addItem(IExecutable $item){
		return array_push($this->_items->value, $item)-1;
	}
	public function addItemTo($index, IExecutable $item){
		if($this->checkOverwriteOption((int)$index)){
			$this->_items->value[(int)$index] = $item;
			return true;
		}
		return false;
	}
	public function getItemAt($index){
		return isset($this->_items->value[(int)$index]) ? $this->_items->value[(int)$index] : null;
	}
	public function removeItem(IExecutable $item){
		$index = $this->indexOf($item);
		if($index===false) return false;
		unset($this->_items->value[$index]);
		return $index;
	}
	public function removeItemAt($index){
		$value = isset($this->_items->value[$index]);
		unset($this->_items->value[$index]);
		return $index;
	}
	public function indexOf(IExecutable $item){
		return array_search($item, $this->_items->value, true);
	}
}

?>