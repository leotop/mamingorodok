<?php
/**
 * Connector.php - memod
 * Initial version by: BeforyDeath
 * Initial version created on: 14.01.14 14:43
 */

namespace classes\connector;

abstract class Connector {
	protected $connector = null;
	protected $config = array();

	abstract public function getConnector();

	public function getConfig($field) {
		if (!empty($this->config[$field])) {
			return $this->config[$field];
		}
		return false;
	}
}