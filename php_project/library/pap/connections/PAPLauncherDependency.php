<?php

/**
 * ���� ������������ ����� ���������� � ������ ����������
 * @author iFrame
 *
 */
class PAPLauncherDependency{
	/**
	 * ��-���������, �� ��� ���������
	 * @var int
	 */
	const NOT_SIGNIFICANT = 0;
	/**
	 * � �������, ���� ���� ������ ��� proc, �� � ������ ������, � ������� connectionOrder �������� ������ �������� proc
	 * @var int
	 */
	const IMPORTANT = 63;
	/**
	 * � �������, ���� ���� ������ ��� proc, �� � ������ ������, � ������� connectionOrder ��� �������� ��������� � ������ ��� �������� proc
	 * @var int
	 */
	const CRITICAL = 127;
}

?>