<?php

class DefaultProtocolTransport extends PAPProtocolTransport {
	public $compressed;
	public function __construct($id='', $destinationId='', $data=null, $index=0, $count=1, $confirm=false, $compressed=false){
		parent::__construct($id, $destinationId, $data, $index, $count, $confirm);
		$this->compressed = $compressed;
	}
}

?>