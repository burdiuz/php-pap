<?php

/**
 * Module launcher helper class with all needed methods to support module launch
 * @author iFrame
 *
 */
class PAPLaunchersHelper extends NonDynamicObject {
	/**
	 * 
	 * @var PAPConnectionsManager
	 */
	private $_manager;
	public function __construct(PAPConnectionsManager $manager){
		$this->_manager = $manager;
	}
	/**
	 * Launcher reported that it was connected
	 * @param IPAPLauncher $launcher
	 */
	public function connected(IPAPLauncher $launcher){
		$this->_manager->launchers()->connectLauncher($launcher);
	}
	/**
	 * Launcher reported as disconnected
	 * @param IPAPLauncher $launcher
	 */
	public function disconnected(IPAPLauncher $launcher){
		$this->_manager->launchers()->disconnectLauncher($launcher);
	}
	/**
	 * Return reserved connection ID for trusted connection
	 * @return string
	 */
	public function bindId(IPAPLauncher $launcher, IDataGroup $config=null, $name='', $level=-1){
		$id = PAPUtils::getUniqueModuleId($name);
		if($this->_manager->registry()->add($id, $config, $name, $level)){
			return $id;
		}
		return false;
	}
	/**
	 * Remove ID from reserved list, this action will decline trusted level for this ID
	 * @param string $id
	 */
	public function unbindId(IPAPLauncher $launcher, $id){
		$this->_manager->registry()->remove($id);
	}
	/**
	 * Current protocol used
	 * @return IPAPProtocolService
	 */
	public function protocol(){
		$this->_manager->protocol();
	}
	/**
	 * Authorize connection, Launcher can not authorize connection by itself, only pass it to manager to complete authorization.
	 * @param IPAPConnection $connection
	 */
	public function authorize(IPAPLauncher $launcher, IPAPConnection $connection){
		
	}
	/**
	 * Report module launch error and remove ID from reserved
	 * @param string $id
	 * @param PAPModuleCommand $command
	 */
	public function reportError(IPAPLauncher $launcher, $id, PAPModuleCommand $command){
		
	}
}

?>