<?php

abstract class PAPProtocolEntity extends NonDynamicObject{
	/**
	 * Unique ID of current entity
	 * @var string
	 */
	public $id;
	/**
	 * Module or Client that sent this entity
	 * @var string
	 */
	public $sourceId;
	/**
	 * Entity RAW data, serialized - in the same state as it was transferred.
	 * @var any
	 */
	public $data;
	public function __construct($id='', $sourceId='', $data=null){
		$this->id = $id;
		$this->sourceId = $sourceId;
		$this->data = $data;
	}
}
?>