<?php

/**
 * 
 * @author iFrame
 *
 */
class PAPModuleAPIAccessLevels {
 /**
  * могут вызывать уровни одного и того же модуля
  * @var int
  */
 const MODULE_ONLY = 0;
 /**
  * могут вызывать модули из группы
  * @var int
  */
 const GROUP_ONLY = 15;
 /**
  * могут вызывать любые модули
  * @var int
  */
 const ANY_MODULE = 31;
 /**
  * могут вызывать все, по-умолчанию
  * @var int
  */
 const ANY = 63;
}

?>