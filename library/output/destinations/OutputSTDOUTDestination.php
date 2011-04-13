<?php

class OutputSTDOUTDestination extends OutputFileDestination{
	public function __construct(){
		parent::__construct(fopen('php://output', 'w'));
	}
}

?>