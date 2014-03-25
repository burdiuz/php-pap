<?php

interface IPAPLauncher extends INamedEntity, IHandlerHolder, IPAPBasicConnection, IExecutable{
	/**
	 * If module supported by this launcher, will add module path & parameters to launch queue.
	 * @param string $id Predefined connection ID, that will be used to identify this module to setup it's trust level.  
	 * @param PAPModuleCommand $module Command that contains module name, level index, path, parameters, config and other info that may be needed to launch this module.
	 * @return boolean  
	 */
	public function launch($id, PAPModuleCommand $module);
	/**
	 * Can this launcher execute passed module command
	 * @param PAPModuleCommand $module
	 * @return boolean
	 */
	public function canLaunch(PAPModuleCommand $module);
	/**
	 * Connection's config, that will be passed to module config, if dependency equals or higher than IMPORTANT
	 * @return IDataGroup
	 */
	public function config();
	/**
	 * @see PAPLauncherDependency
	 * @return int
	 */
	public function typeDependency();
}

?>