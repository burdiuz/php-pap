<?php
echo "START";
set_time_limit(0);
for($i=0; $i<5; $i++){
	echo "-$i-";
	flush();
	usleep(250000);
}
sleep(1);
echo "END";
exit;

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

define('PAP_LIBRARY_PATH', './library/');

if($_SERVER['REMOTE_ADDR']!=$_SERVER['SERVER_ADDR']) exit();

require_once PAP_LIBRARY_PATH.'ErrorHandler.php';
require_once PAP_LIBRARY_PATH.'ClassLibrary.php';

ClassLibrary::initialize();
ClassLibrary::registerRecursive('library');
PAPConfig::readInput();
Output::enable();
// У модуля должно быть две фазы -- инициализация и работа, первая проходит быстро, а вторая, это бесконечный цыкл.
/*
 * Статус должен возвращаться самим модулем, надо предусмотреть в интерфейсе модуля метод IPAPModule.getStatus();
 * Ау объекта статуса должны быть методы 
 * PAPModuleStatus::encode - возвращает строку статуса для парсинга
 * PAPModuleStatus::decode - возвращает объект статуса
 * PAPModuleStatus::search - производит поиск закодированого статуса в строке и декодирует его
 * PAPModuleStatus.__toString, который выдаёт статус модуля в виде удобном для чтения
 * В конфиг добавить параметры
 * -enable-output
 * -return-status
 * Враппер может использовать эти параметры для регулировки вывода
 * или так
 * -output-control
 * 	0 - off
 *  1 - on
 *  2 - encoded status only
 *  3 - encoded status and output
 *  4 - status string only
 *  5 - status string and output
 * Фазы работы враппера
 * 1. Инициализация враппера -- PAPHTTPModuleWrapper::initialize();
 * 2. Установка всех необходимых комплектующих, вроде Output, ErrorHandler, PAPConfig
 * 3. Старт отлова ошибок
 * 4. Подключение всех файлов модуля
 * 5. Инициализация модуля
 * 6. Отправка статуса
 * 7. Звершение работы враппера и запуск работы модуля
 * 
 */
?>