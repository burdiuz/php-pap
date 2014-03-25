<?php

/**
 * типы зависимостей между лаунчерами и типами соединения
 * @author iFrame
 *
 */
class PAPLauncherDependency{
	/**
	 * по-умолчанию, всё без изменений
	 * @var int
	 */
	const NOT_SIGNIFICANT = 0;
	/**
	 * к примеру, если этот указан для proc, то в конфиг модуля, в массиве connectionOrder появится первое значение proc
	 * @var int
	 */
	const IMPORTANT = 63;
	/**
	 * к примеру, если этот указан для proc, то в конфиг модуля, в массиве connectionOrder все значения удаляться и вместо них появится proc
	 * @var int
	 */
	const CRITICAL = 127;
}

?>