<?php

class OutputComplexDestination extends NonDynamicObject implements IOutputDestination {
	private $_list;
	public function __construct($list){
		if($list && is_array($list) && count($list)){
			$this->_list = $list;
		}else{
			throw new Exception('OutputComplexDestination Error: Constructor accepts list of one or more IOutputDestination instances.');
		}
	}
	public function write($data){
		foreach($this->_list as /** @var IOutputDestination */ $destination){
			$destination->write($data);
		}
	}
}

?>