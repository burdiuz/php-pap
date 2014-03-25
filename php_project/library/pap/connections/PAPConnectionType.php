<?php

final class PAPConnectionType {
	const CLIENT = 'client';
	const MODULE = 'module';
	static public function getType(IPAPConnection $connection){
		return $connection->moduleName() ? self::MODULE : self::CLIENT;
	}
	static public function isModule(IPAPConnection $connection){
		return (boolean)$connection->moduleName();
	}
	static public function isClient(IPAPConnection $connection){
		return !(boolean)$connection->moduleName();
	}
}

?>