<?php
/**
 * В него можно добавлять экземпляры ICallable и указывать сколько аргументов каждому можно передать(от нуля)
 * @author iFrame
 *
 */
class CompositeHandler extends HandlerCollection{
	protected $_counts = array();
	public function addItem(ICallable $item, $count=1){
		if($item){
			array_push($this->_items, $item);
			array_push($this->_counts, (int)$count);
		}
	}
	public function getCountAt($index){
		isset($this->_counts[$index]) ? $this->_counts[$index] : false;
	}
	public function getCountFor(ICallable $item){
		$index = $this->getItemIndex($item);
		$count = false;
		if($index!==false){
			$count = $this->getCountAt($index);
		}
		return $count;
	}
	public function removeItemAt($index){
		parent::removeItemAt($index);
		array_splice($this->_counts, $index, 1);
	}
	public function call($arguments){
		foreach($this->_items as $index=>/** @var ICallable */$handler){
			$handler->call(array_splice($arguments, 0, $this->_counts[$index]));
		}
	}
}

?>