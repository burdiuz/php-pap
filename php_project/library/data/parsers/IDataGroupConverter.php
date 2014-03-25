<?php

interface IDataGroupConverter {
	/**
	 * Convert data to IDataGroup instance
	 * @param any $data
	 * @param IDataGroup $group
	 * @return IDataGroup
	 */
	static public function convert($data, IDataGroup $group=null);
}

?>