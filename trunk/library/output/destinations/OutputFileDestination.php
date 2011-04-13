<?php

class OutputFileDestination extends NonDynamicObject implements IOutputDestination {
	protected $_handler;
	/**
	 * 
	 * @param resource $handler Writeable resource
	 * @throws Exception If no resource passed
	 */
	public function __construct($handler){
		if(is_resource($handler)){
			$this->_handler = $handler;
		}else{
			throw new Exception('OutputFileDestination Error');
		}
	}
	public function write($data){
		fwrite($this->_handler, $data);
	}

}

?>