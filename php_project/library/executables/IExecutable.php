<?php

/**
 * Интерфейс для объектов вызываемых в рабочем цикле
 * @author Oleg
 *
 */
interface IExecutable {
	/**
	 * @return boolean
	 */
	public function execute();
}

?>