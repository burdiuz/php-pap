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
// � ������ ������ ���� ��� ���� -- ������������� � ������, ������ �������� ������, � ������, ��� ����������� ����.
/*
 * ������ ������ ������������ ����� �������, ���� ������������� � ���������� ������ ����� IPAPModule.getStatus();
 * �� ������� ������� ������ ���� ������ 
 * PAPModuleStatus::encode - ���������� ������ ������� ��� ��������
 * PAPModuleStatus::decode - ���������� ������ �������
 * PAPModuleStatus::search - ���������� ����� �������������� ������� � ������ � ���������� ���
 * PAPModuleStatus.__toString, ������� ����� ������ ������ � ���� ������� ��� ������
 * � ������ �������� ���������
 * -enable-output
 * -return-status
 * ������� ����� ������������ ��� ��������� ��� ����������� ������
 * ��� ���
 * -output-control
 * 	0 - off
 *  1 - on
 *  2 - encoded status only
 *  3 - encoded status and output
 *  4 - status string only
 *  5 - status string and output
 * ���� ������ ��������
 * 1. ������������� �������� -- PAPHTTPModuleWrapper::initialize();
 * 2. ��������� ���� ����������� �������������, ����� Output, ErrorHandler, PAPConfig
 * 3. ����� ������ ������
 * 4. ����������� ���� ������ ������
 * 5. ������������� ������
 * 6. �������� �������
 * 7. ��������� ������ �������� � ������ ������ ������
 * 
 */
?>