<?php

/**
 * Class wrapper for handler method
 * @author iFrame
 *
 */
class MethodHandler extends PropertyHandler implements IMultiValueHandler{
	protected $_link;
	/**
	 * Creates new instance of MethodHandler
	 * @param object $target Target object that contains handler method
	 * @param string $name Handler method name
	 */
	public function __construct($target, $name){
		parent::__construct($target, $name);
		$this->_link = array($this->_target, $this->_name);
	}
	/**
	 * Call handler method with arguments passed
	 * @param array $arguments Arguments to be passed to handler method
	 */
	public function call($arguments){
		call_user_func_array($this->_link, $arguments);
	}
	/**
	 * Call handler method with arguments passed to this method with the same order
	 * 
	 */
	public function apply(){
		call_user_func_array($this->_link, func_get_args());
	}
}

?>