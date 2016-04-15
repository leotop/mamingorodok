<?php
/**
 * MySQLi.php - memod
 * Initial version by: BeforyDeath
 * Initial version created on: 14.01.14 14:45
 */

namespace classes\connector;


class MySQLi extends Connector
{
	public function __construct($config) {
		$this->config = $config;
		mysqli_report(MYSQLI_REPORT_OFF);
//		mysqli_report(MYSQLI_REPORT_ALL);
		$this->connector = new \mysqli($config['host'], $config['user'], $config['pass'], $config['name']);
		if (mysqli_connect_errno()) {
			die(json_encode(array("exception" => "Connect error: #" . mysqli_connect_errno() . ' ' . mysqli_connect_error())));
		}
		$this->connector->set_charset($config['encode']);
		$this->checkError();
	}

	private function checkError() {
		if ($this->connector->error) {
			die(json_encode(array("exception" => "#" . $this->connector->errno . ' ' . $this->connector->error)));
		}
	}

	/**
	 * @return MySQLi
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

	public function setID($query) {
		$this->query($query);
		return $this->connector->insert_id;
	}

	/**
	 * @param $query
	 * @return bool|\mysqli_result
	 */
	protected function query($query) {
		if (!$result = $this->connector->query($query)) {
			$this->checkError();
		}
		return $result;
	}

	protected function select($query, $key = null) {
		$resource = $this->query($query);
		$result = array();
		if ($resource) {
			if (is_null($key)) {
				while ($row = $resource->fetch_assoc()) {
					$result[] = $row;
				}
			} else {
				while ($row = $resource->fetch_assoc()) {
					$result[$row[$key]] = $row;
				}
			}
		}
		return $result;
	}

	protected function selectKey($query, $key) {
		$resource = $this->query($query);
		$result = array();
		if ($resource) {
			while ($row = $resource->fetch_assoc()) {
				$result[] = $row[$key];
			}
		}
		return $result;
	}
	public function disconnect()
	{
		if ($this->connector){
			$this->connector->close();
		}
		return false;
	}

} 