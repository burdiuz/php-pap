<?php

/**
 * Объект создающий экземпляры объектов управляющих определённым типом соединения. 
 * Каждый из методов может вернуть NULL, если эта возможность не предусмотрена в данном случае.
 * @author iFrame
 *
 */
interface IPAPConnectionFactory extends INamedEntity{
	const CREATE_INSTANCE_METHOD = 'getInstance';
	/**
	 * Используется в ядре для получения инспектора, который следит за появлением новых соединений с ядром.
	 * @param IPAPInspectorHandler $handler
	 * @return IPAPConnectionInspector|NULL
	 */
	public function getInspector(PAPInspectorsHelper $helper);
	/**
	 * Используется в клиентах и модулях для получения правильно настроенного объекта соединения.
	 * @return IPAPConnection
	 */
	public function getConnection(IPAPConnectionsHelper $helper);
	/**
	 * Объект способный запускать модули
	 * @param IPAPLauncherHandler $handler
	 * @return IPAPLauncher|NULL
	 */
	public function getLauncher(PAPLaunchersHelper $helper);
	/**
	 * Объект способный запускать ядро
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