<?php

class PAPProtocolPacket extends PAPProtocolEntity{
	/**
	 * Data type of entity
	 * @see PAPProtocolEntityType
	 * @var int
	 */
	public $type;
	/**
	 * Reason of sending this data, for example: authorization, configuration
	 * @see PAPProtocolEntityReason
	 * @var string
	 */
	public $reason;
	/**
	 * Date in timestamp, when this entity was created
	 * @var int
	 */
	public $created;
	public function __construct($id='', $sourceId='', $type=0, $reason='', $data=null, $time=0){
		parent::__construct($id, $sourceId, $data);
		$this->type = $type;
		$this->reason = $reason;
		$this->created = $time;
	}
}

?>