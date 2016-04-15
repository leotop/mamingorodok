<?php
/**
 * Server.php - memod
 * Initial version by: BeforyDeath
 * Initial version created on: 06.01.14 12:16
 */

namespace classes;

use classes\connector\Connector;
use classes\connector\MySQLi;

class Server {
	/**
	 * @var MySQLi|null
	 */
	private $db = null;

	public function __construct(Connector $db) {
		$this->db = $db;
	}

	public function get($query) {
		return $this->db->get($query);
	}

	public function set($query) {
		return $this->db->set($query);
	}

	public function getConfig($field) {
		return $this->db->getConfig($field);
	}

	/**
	 * @param $query
	 * @return int
	 */
	public function setID($query) {
		$id = $this->db->setID($query);
// todo хрень не понял
//		return $id[0];
		return $id;
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return bool
	 */
	public function __call($name, $arguments) {
		return false;
	}
}