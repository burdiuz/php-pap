<?php

/**
 * ������ ��������� ���������� �������� ����������� ����������� ����� ����������. 
 * ������ �� ������� ����� ������� NULL, ���� ��� ����������� �� ������������� � ������ ������.
 * @author iFrame
 *
 */
interface IPAPConnectionFactory extends INamedEntity{
	const CREATE_INSTANCE_METHOD = 'getInstance';
	/**
	 * ������������ � ���� ��� ��������� ����������, ������� ������ �� ���������� ����� ���������� � �����.
	 * @param IPAPInspectorHandler $handler
	 * @return IPAPConnectionInspector|NULL
	 */
	public function getInspector(PAPInspectorsHelper $helper);
	/**
	 * ������������ � �������� � ������� ��� ��������� ��������� ������������ ������� ����������.
	 * @return IPAPConnection
	 */
	public function getConnection(IPAPConnectionsHelper $helper);
	/**
	 * ������ ��������� ��������� ������
	 * @param IPAPLauncherHandler $handler
	 * @return IPAPLauncher|NULL
	 */
	public function getLauncher(PAPLaunchersHelper $helper);
	/**
	 * ������ ��������� ��������� ����
	 * @return IPAPCoreLauncher|NULL
	 */
	public function getCoreLauncher();
	/**
	 * Will return TRUE if this type of connection is supported on this platform.
	 * @return boolean
	 */
	public function isSupported();
	/**
	 * Create factory instance, if not exists, and return it
	 * @param IPAPProtocolService $protocol
	 * @param IDataGroup $config
	 * @return IPAPConnectionFactory
	 */
	static public function getInstance(IDataGroup $config=null);
}

?>