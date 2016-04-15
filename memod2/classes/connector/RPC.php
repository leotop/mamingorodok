<?php
/**
 * RPC.php - memod
 * Initial version by: BeforyDeath
 * Initial version created on: 13.01.14 13:49
 */

namespace classes\connector;

use classes\Server;
use libraries\jsonrpc2\jsonRPC2Client;

class RPC extends Connector
{
	public function __construct($config) {
		$this->config = $config;
		$this->connector = new jsonRPC2Client($config['url'], $config['class'], $config['authentication']);
	}

	/**
	 * @return Server
	 */
	public function getConnector() {
		return $this->connector;
	}
}
