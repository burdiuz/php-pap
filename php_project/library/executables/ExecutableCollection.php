<?php

abstract class ExecutableCollection extends NonDynamicObject implements IExecutableCollection{
	/**
	 * @var boolean
	 */
	protected $_allowOverwrite;
	/**
	 * @var boolean
	 */
	protected $_throwExceptions;
	/**
	 * @var ValueHolder
	 */
	protected $_items;
	/**
	 * 
	 * @param array $items
	 * @param boolean $allowOverwrite Will collection allow to overwrite existing items
	 * @param boolean $throwExceptions Throw exception if something goes wrong
	 */
	public function __construct($items=null, $allowOverwrite=false, $throwExceptions=true){
		$this->_items = new ValueHolder(is_array($items) ? $items : array());
		$this->_allowOverwrite = $allowOverwrite;
		$this->_throwExceptions = $throwExceptions;
	}
	protected function checkOverwriteOption($key){
		if(isset($this->_items->value[$key]) && !$this->_allowOverwrite){
			if($this->_throwExceptions){
				throw new Exception('ExecutableCollection Error: Empty items is not allowed in this collection.');
			}
			return false;
		}
		return true;
	}
	public function removeItem(IExecutable $item){
		throw new Exception('ExecutableCollection Error: ExecutableCollection::removeItem() method must be overridden.');
	}
	public function hasItem(IExecutable $item){
		return in_array($item, $this->_items->value, true);
	}
	public function toArray(){
		return $this->_items->value;
	}
	public function count(){
		return count($this->_items->value);
	}
	public function execute(){
		$value = false;
		foreach($this->_items->value as /** @var IExecutable */ $item){
			if($item){
				$value = $value || $item->execute();
			}
		}
		return $value;
	}
	public function getIterator(){
		return new ExecutableCollectionIterator($this->_items);
	}
	public function __destruct(){
		$this->_items->value = null;
	}
}

?>