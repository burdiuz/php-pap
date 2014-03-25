<?php

interface IPAPModuleInfo {
	public function getId();
	public function getName();
	public function getIndex();
	public function getAccessLevel();
	public function getTrustLevel();
	public function getCurrentState();
	public function isLaunched();
	public function isRegistered();
}

?>