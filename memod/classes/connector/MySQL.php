<?php
/**
 * MySQL.php - memod
 * Initial version by: BeforyDeath
 * Initial version created on: 14.01.14 14:48
 */

namespace classes\connector;

class MySQL extends Connector
{
	public function __construct($config) {
		$this->config = $config;
		$this->connector = mysql_connect($config['host'], $config['user'], $config['pass']);
		mysql_set_charset($config['encode'], $this->connector);
		mysql_select_db($config['name'], $this->connector);
		$this->checkError();
	}

	private function checkError() {
		if (mysql_errno($this->connector)) {
			throw new \Exception(mysql_errno($this->connector), mysql_error($this->connector));
		}
	}

	public function query($query) {
		if (!$result = mysql_query($query)) {
			$this->checkError();
		}
		return $result;
	}

	public function select($query, $key = null) {
		$resource = $this->query($query);
		$result = array();
		if ($resource) {
			if (is_null($key)) {
				while ($row = mysql_fetch_assoc($resource)) {
					$result[] = $row;
				}
			} else {
				while ($row = mysql_fetch_assoc($resource)) {
					$result[$row[$key]] = $row;
				}
			}
		}
		return $result;
	}

	public function selectKey($query, $key) {
		$resource = $this->query($query);
		$result = array();
		if ($resource) {
			while ($row = mysql_fetch_assoc($resource)) {
				$result[] = $row[$key];
			}
		}
		return $result;
	}

	/**
	 * @return MySQL
	 */
	public function getConnector() {
		return $this;
	}

	public function get($query) {
		return $this->select($query);
	}

	public function set($query) {
		return $this->query($query);
	}
}