<?php
class PAPModuleCommand extends NonDynamicObject{
	/**
	 * Name of the module
	 * @var string
	 */
	private $_name;
	/**
	 * Level of module for which this command applied
	 * @var int
	 */
	private $_level;
	/**
	 * Path to module, for launcher
	 * @var string
	 */
	private $_path;
	/**
	 * Module config, that was passed to  core as default
	 * @var IDataGroup
	 */
	private $_config;
	/**
	 * Используется в RAW запуске
	 * @var array
	 */
	private $_parameters;
	/**
	 * Module's working dir
	 * @var string
	 */
	private $_workingDir;
	public function __construct(IDataGroup $config=null, $name=null, $level=-1, $path=null, $parameters=null, $workingDir=null){
		$this->_name = $name;
		$this->_level = $level;
		if($config){
			$this->setConfig($config, $path, $parameters, $workingDir);
		}else{
			$this->_path = $path;
			$this->_parameters = $parameters ? $parameters : array();
			$this->_workingDir = $workingDir ? $workingDir : sys_get_temp_dir();
		}
	}
	private function setConfig(IDataGroup $config, $path=null, $parameters=null, $workingDir=null){
		if(!$this->_name) $this->_name = $config->value(PAPModuleConfig::NAME);
		$this->_path = $path ? $path : $config->value(PAPModuleConfig::PATH);
		$this->_workingDir = $workingDir ? $workingDir : $config->value(PAPModuleConfig::WORKING_DIR, sys_get_temp_dir());
		$this->_parameters = PAPModuleConfig::exportParameters($config);
		if(!is_null($parameters)){
			foreach($parameters as $key=>$value){
				$this->_parameters[$key] = $value;
			}
		}
		$this->_config = $config;
	}
	public function name(){
		return $this->_name;
	}
	public function level(){
		return $this->_level;
	}
	public function path(){
		return $this->_path;
	}
	public function parameters(){
		return $this->_parameters;
	}
	public function config(){
		return $this->_config;
	}
	public function workingDir(){
		return $this->_workingDir;
	}
	public function validate(){
		if(!$this->_name){
			throw new Exception('PAPModuleCommand Error: Module name is empty, must be defined.');
		}
		if(!$this->_path){
			throw new Exception('PAPModuleCommand Error: Module "'.$this->_name.'" path is empty, must be defined.');
		}
		if(!$this->_workingDir){
			throw new Exception('PAPModuleCommand Error: Module "'.$this->_name.'" working dir is empty, must be defined.');
		}
	}
}
?>