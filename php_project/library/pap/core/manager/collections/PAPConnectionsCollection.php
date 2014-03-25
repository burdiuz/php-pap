<?php

/**
 * Already connected modules and clients
 * @author iFrame
 *
 */
class PAPConnectionsCollection extends NonDynamicObject implements IExecutable{
	private $_ids = array();
	private $_levels = array();
	/**
	 * Get connection instance by ID
	 * @param string $id
	 * @return IPAPConnection|NULL
	 */
	public function getById($id){
		return isset($this->_ids[$id]) ? $this->_ids[$id] : null;
	}
	/**
	 * Get list of connections for all instances of the same module
	 * @param string $name
	 * @return IPAPConnection[]
	 */
	public function getByName($name){
		return isset($this->_levels[(string)$name]) ? $this->_levels[(string)$name] : array();
	}
	/**
	 * Get connection by name and level
	 * @param string $name
	 * @param int $index
	 * @return IPAPConnection|NULL
	 */
	public function geByLevel($name, $index){
		$list = $this->geByName($name);
		return $list && isset($list[(int)$index]) ? $list[(int)$index] : null;
	}
	/**
	 * Add connection
	 * @param IPAPHostConnection $connection
	 * @throws Exception
	 * @return boolean|int
	 */
	public function add(IPAPConnection $connection){
		if(!$connection || $connection->isConnected() || !$connection->id()){
			throw new Exception('PAPModuleLevels Error: Module connection must be connected and have own connection ID.');
		}
		$name = $connection->moduleName();
		if(isset($this->_levels[$name])) $levels = $this->_levels[$name];
		else $levels = array();
		$index = $connection->moduleLevel();
		if($index>=0){
			if(isset($levels[$index])) return false;
		}else{
			$index = 0;
			while(isset($levels[$index])){
				$index++;
			}
		}
		try{
			$connection->setModuleLevel($index);
		}catch(Exception $error){
			return false;
		}
		$this->_ids[$connection->id()] = $connection;
		$levels[$index] = $connection;
		$this->_levels[$name] = $levels;
		return $index;
	}
	/**
	 * Remove Module connection by its ID
	 * @param string $id
	 * @return IPAPConnection|boolean
	 */
	public function removeById($id){
		$connection = false;
		if(isset($this->_ids[$id])){
			/** @var IPAPConnection */ $connection = $this->_ids[$id];
			unset($this->_ids[$id]);
			$name = $connection->moduleName();
			unset($this->_levels[$name][$connection->moduleLevel()]);
			if(!$this->count($name)){
				unset($this->_levels[$name]);
			}
		}
		return $connection;
	}
	/**
	 * Remove Module connection by level index
	 * @param string $name
	 * @param int $index
	 * @return IPAPConnection|boolean
	 */
	public function removeByLevel($name, $index){
		$connection = false;
		if(!isset($this->_levels[$name])) return $connection;
		/** @var IPAPConnection[] */$levels = $this->_levels[$name];
		if(isset($levels[$index])){
			/** @var IPAPConnection */ $connection = $this->_levels[$index];
			unset($this->_ids[$connection->id()]);
			unset($this->_levels[$name][$index]);
			if(!$this->count($name)){
				unset($this->_levels[$name]);
			}
		}
		return $connection;
	}
	/**
	 * Find level index of connection, also you can use IPAPConnection->moduleLevel(), after connection was initialized
	 * @param IPAPConnection $connection
	 * @return int|boolean
	 */
	public function levelOf(IPAPConnection $connection){
		return isset($this->_levels[$connection->moduleName()]) ? array_search($connection, $this->_levels[$connection->moduleName()], true) : false;
	}
	/**
	 * Get count of launched connections of module, by its name
	 * @param string $name
	 * @return int
	 */
	public function count($name){
		return isset($this->_levels[$name]) ? count($this->_levels[$name]) : 0;
	}
	/**
	 * Is mopdule level available to launch, is it free from connection
	 * @param unknown_type $name
	 * @param unknown_type $index
	 * @return boolean
	 */
	public function isAvailable($name, $index){
		return !isset($this->_levels[(string)$name][(int)$index]);
	}
	public function execute(){
		foreach ($this->_ids as /** @var IPAPConnection */ $connection){
			$connection->execute();
		}
	}
	public function __destruct(){
		$this->_ids = null;
		$this->_levels = null;
	}
}

?>