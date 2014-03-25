<?php

interface IPAPProtocolService {
	const DEFAULT_EOP = 10;
	/**
	 * Protocol name
	 * @return string
	 */
	public function name();
	/**
	 * ���������� ������ ������������� ������
	 * @param string $string
	 * @return PAPProtocolTransport[]
	 */
	public function readTransport($string);
	/**
	 * ������������� ������ �� ���� ����������� � ���������� ������ ��������� ���������� �������, ����� �� ���������� �������� ������
	 * @param PAPProtocolTransport $transport
	 * @return PAPProtocolEntity[]
	 */
	public function readEntities(PAPProtocolTransport $transport);
	/**
	 * 
	 * @param string $string
	 * @return PAPProtocolEntity
	 */
	public function readEntity($string);
	/**
	 * ���������� ������ ������� ��������������� ������� � ��������
	 * @param string $id
	 * @param string $destinationId
	 * @param PAPProtocolEntity[] $entities
	 * @param boolean $confirm
	 * @param int $maxPacketSize
	 * @return string[]
	 */
	public function writeTransport($id, $destinationId, $entities, $confirm, $maxPacketSize=0);
	/**
	 * Serialize protocol entities into a strings
	 * @param PAPProtocolEntity $entity
	 * @return string[]
	 */
	public function writeEntity(PAPProtocolEntity $entity);
	/**
	 * If service and it's config compatible method will return true.
	 * ���� ����� ����� ��� ����, ���� ����� -- ����� �� �������������� ������ ����� �����������  
	 * @param IPAPProtocolService $service
	 * @return boolean
	 */
	public function isCompatible(IPAPProtocolService $service);
	/**
	 * Will return TRUE only if current protocol service can be used on this system -- if all extensions needed to work with it is installed and so on.
	 * @return boolean
	 */
	public function isSupported();
	/**
	 * 
	 * @param IDataGroup $config
	 * @param int $maxPacketSize
	 * @param string $name Proposed name, if noname protocol used
	 * @return IPAPProtocolService
	 */
	static public function getInstance(IDataGroup $config);
}

?>