<?php

interface IPAPSocketLauncherMethod {
	/**
	 * Create writeable resource and make PAPSocketLauncherHandler instance to store its information
	 * @param string $id
	 * @param PAPModuleCommand $command
	 * @return PAPSocketLauncherHandler
	 */
	public function write($id, PAPModuleCommand $command);
	/**
	 * Check resource saved in PAPSocketLauncherHandler instance and check for its output.  
	 * @param PAPSocketLauncherHandler $handler
	 * @return boolean TRUE if it has output
	 */
	public function read(PAPSocketLauncherHandler $handler);
	/**
	 * May correct received output to remove HTTP headers and other not sufficient data.
	 * @param PAPSocketLauncherHandler $handler
	 */
	public function finish(PAPSocketLauncherHandler $handler);
}

?>