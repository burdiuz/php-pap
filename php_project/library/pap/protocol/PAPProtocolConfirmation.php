<?php

class PAPProtocolConfirmation extends PAPProtocolEntity{
	/**
	 * The status of packet delivery
	 * @return int
	 */
	public $status;
	public function __construct($id='', $sourceId='', $status=0, $data=null){
		parent::__construct($id, $sourceId, $data);
		$this->status = $status;
	}
}

?>