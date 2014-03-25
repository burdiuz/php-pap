<?php

class PAPProtocolTransport extends NonDynamicObject{
	public $id;
	public $destinationId;
	public $confirm;
	public $data;
	public $index;
	public $count;
	public function __construct($id='', $destinationId='', $data=null, $index=0, $count=1, $confirm=false){
		$this->id = $id;
		$this->destinationId = $destinationId;
		$this->data = $data;
		$this->index = $index;
		$this->count = $count;
		$this->confirm = $confirm;
	}
}

?>