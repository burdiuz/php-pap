<?php

/**
 * Represents indexed list of WorkingCycle states 
 * @author iFrame
 *
 */
interface IWorkingCycleStateList {
	public function current();
	public function currentIndex();
	public function isLast();
	public function reset();
	public function previous();
	public function next();
	public function count();
	public function lastIndex();
}

?>