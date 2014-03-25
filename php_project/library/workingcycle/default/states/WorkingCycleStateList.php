<?php

class WorkingCycleStateList implements IWorkingCycleStateList{
	private $_states;
	private $_count;
	public function __construct($list=null){
		if($list){
			$this->_states = array();
			$index = 0;
			foreach($list as /** @var IWorkingCycleState */$state){
				if($state && $state instanceof WorkingCycleState){
					array_push($this->_states, $state);
				}
			}
		}
		$this->_count = count($this->_states);
	}
	public function current(){
		return current($this->_states);
	}
	public function currentIndex(){
		return (int)key($this->_states);
	}
	public function isLast(){
		return !(boolean)current($this->_states);
	}
	public function reset(){
		return reset($this->_states);
	}
	public function previous(){
		return prev($this->_states);
	}
	public function next(){
		return next($this->_states);
	}
	public function count(){
		return $this->_count;
	}
	public function lastIndex(){
		return $this->_count-1;
	}
	/**
	 * @param IDataGroup $group
	 * @return WorkingCycleStateList
	 */
	static public function get(IDataGroup $group){
		/** @var WorkingCycleStateList */
		$states = null;
		if($group->hasGroup(WorkingCycleParameters::GROUP_STATE)){
			/** @var IDataLevels */
			$list = $group->group(WorkingCycleParameters::GROUP_STATE);
			$count = $list->count();
			$array = array();
			for($index=0; $index<$count; $index++){
				array_push($array, WorkingCycleState::get($index, $list->level($index)));
			}
			if(count($array)) $states = new WorkingCycleStateList($array);
		}
		return $states;
	}
	/**
	 * @return WorkingCycleStateList
	 */
	static public function getDefault(){
		return new WorkingCycleStateList(array(WorkingCycleState::getDefault()));
	}
}

?>