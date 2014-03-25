<?php

class PAPModuleLaunchStatus extends PAPProtocolEntity{
	const NO_OUTPUT = 0;
	const RAW_OUTPUT = 1;
	const LAUNCHED = 2;
	const LAUNCHED_WITH_ERRORS = 4;
	const MODULE_ERROR = 8;
	const CONNECTION_ERROR = 16;
	/**
	 * @private
	 * @var string
	 */
	static private $SPACER = ',';
	/**
	 * @private
	 * @var string
	 */
	static private $EOL = "\n";
	static private $BORDER = "\0";
	public $status;
	public function __construct($moduleId, $status=self::RAW_OUTPUT, $data=null){
		parent::__construct(PAPUtils::getUniqueEntityId('status'), $moduleId, $data);
		$this->status = $status;
	}
	public function __toString(){
		$status = (int)$this->status;
		return self::$BORDER.$this->sourceId.self::$SPACER.$status.self::$SPACER.PAPUtils::packData($this->data, self::$EOL).self::$BORDER.self::$EOL;
	}
	static public function parse($data){
		/** @var PAPModuleLaunchStatus */ $instance = null;
		$data = rtrim($data, self::$EOL);
		$idIndex = strpos($data, self::$SPACER);
		if($idIndex>=0){
			$id = substr($data, 0, $idIndex);
			$idIndex++;
			$statusIndex = strpos($data, self::$SPACER, $idIndex);
			if($statusIndex>=0){
				$status = substr($data, $idIndex, $statusIndex-$idIndex);
				return new PAPModuleLaunchStatus($id, (int)$status, PAPUtils::unpackData(substr($data, $statusIndex+1)));
			}
		}
		return null;
	}
	static public function extract($data){
		//TODO find status from entire output string 
	}
}


?>