<?php
/**
 * Двухуровневая структура позволяет использовать один тип соединения много раз 
 * @author iFrame
 *
 */
class PAPConnectionsManagerCollection extends NonDynamicObject implements IExecutable{
	/**
	 * @var boolean
	 */
	private $_allowOverwrite;
	/**
	 * @var boolean
	 */
	private $_throwExceptions;
	/**
	 * 
	 * @var ExecutableHash
	 */
	private $_hash;
	public function __construct($allowOverwrite=false, $throwExceptions=true){
		$this->_allowOverwrite = $allowOverwrite;
		$this->_throwExceptions = $throwExceptions;
		$this->_hash = new ExecutableHash($this->_allowOverwrite, $this->_throwExceptions);
	}
	protected function addItem($name, IExecutable $item){
		/** @var ExecutableList */$list = $this->getItems($name, true);
		$list->addItem($item);
	}
	protected function addNamedItem(INamedEntity $item){
		/** @var ExecutableList */$list = $this->getItems($item->name(), true);
		$list->addItem($item);
	}
	protected function addItems($name, $items){
		if(empty($items)) return;
		/** @var ExecutableList */$list = $this->getItems($name, true);
		foreach($items as /** @var IExecutable */ $item){
			$list->addItem($item);
		}
	}
	protected function addNamedItems($items){
		if(empty($items)) return;
		foreach($items as /** @var INamedEntity */ $item){
			/** @var ExecutableList */$list = $this->getItems($item->name(), true);
			$list->addItem($item);
		}
	}
	/**
	 * Remove item from list
	 * @param string $name
	 * @param IExecutable $item
	 * @return boolean
	 */
	protected function removeItem($name, IExecutable $item){
		/** @var ExecutableList */$list = $this->_hash->getItemByKey($name);
		if($list){
			$list->removeItem($item);
			$this->removeIfEmpty($name);
			return true;
		}
		return false;
	}
	protected function removeNamedItem(INamedEntity $item){
		/** @var string */$name = $item->name();
		/** @var ExecutableList */$list = $this->_hash->getItemByKey($name);
		if($list){
			$list->removeItem($item);
			$this->removeIfEmpty($name);
			return true;
		}
		return false;
	}
	/**
	 * Was item added to this collection 
	 * @param string $name
	 * @param IExecutable $item
	 * @return boolean
	 */
	protected function isItemExists($name, IExecutable $item){
		/** @var ExecutableList */$list = $this->_hash->getItemByKey($name);
		if($list){
			return (boolean)$list->indexOf($item);
		}
		return false;
	}
	/**
	 * Was item added to this collection
	 * @param INamedEntity $item
	 * @return boolean
	 */
	protected function isNamedItemExists(INamedEntity $item){
		/** @var string */$name = $item->name();
		/** @var ExecutableList */$list = $this->_hash->getItemByKey($name);
		if($list){
			return (boolean)$list->indexOf($item);
		}
		return false;
	}
	/**
	 * Remove list of items by list name
	 * @param string $name
	 * @return ExecutableList Removed list
	 */
	protected function removeItems($name){
		return $this->_hash->removeItemByKey($name);
	}
	/**
	 * Get IExecutable item by name and index
	 * @param string $name
	 * @param int $index
	 * @return IExecutable
	 */
	protected function getItem($name, $index){
		/** @var IExecutable */$item = null;
		/** @var ExecutableList */$list = $this->_hash->getItemByKey($name);
		if($list){
			$list = new ExecutableList();
			$item = $list->getItemAt($index);
		}
		return $item;
	}
	/**
	 * All items added to this collection in named structure, original hash
	 * @return ExecutableHash
	 */
	protected function getAll(){
		return $this->_hash;
	}
	/**
	 * Get items list
	 * @param string $name
	 * @param boolean $createIfNotExists If selected, will create empty list it it is not exists
	 * @return ExecutableList
	 */
	protected function getItems($name, $createIfNotExists=false){
		/** @var ExecutableList */$list = $this->_hash->getItemByKey($name);
		if(!$list && $createIfNotExists){
			$list = new ExecutableList($this->_allowOverwrite, $this->_throwExceptions);
			$this->_hash->addItemByKey($name, $list);
		}
		return $list;
	}
	/**
	 * Check is named list empty and if so -- remove it
	 * @param string $name
	 * @return boolean
	 */
	protected function removeIfEmpty($name){
		/** @var ExecutableList */$list = $this->_hash->getItemByKey($name);
		if($list && !$list->count()){
			return $this->_hash->removeItemByKey($name);
		}
		return false;
	}
	/**
	 * Get items count in list
	 * @param string $name
	 * @return int
	 */
	protected function count($name){
		/** @var int */$count = 0;
		/** @var ExecutableList */$list = $this->_hash->getItemByKey($name);
		if($list){
			$count = $list->count();
		}
		return $count;
	}
	/**
	 * Count all items in all available lists
	 * @return int
	 */
	protected function countAll(){
		/** @var int */$count = 0;
		foreach ($this->_hash as /** @var ExecutableList */$list){
			$count += $list->count();
		}
		return $count;
	}
	public function execute(){
		$this->_hash->execute();
	}
}

?>