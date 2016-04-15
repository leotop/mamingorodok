<?php
/**
 * index.php - memod
 * Initial version by: BeforyDeath
 * Initial version created on: 06.01.14 12:01
 */

use \classes\connector\MySQLi;
use \libraries\jsonrpc2\jsonRPC2Server;
use \classes\Server;

header('Content-Type: application/json');
error_reporting(0);

// fix apache
if( !function_exists('apache_request_headers') ) {
	function apache_request_headers() {
		$arh = array();
		$rx_http = '/\AHTTP_/';
		foreach($_SERVER as $key => $val) {
			if( preg_match($rx_http, $key) ) {
				$arh_key = preg_replace($rx_http, '', $key);
				$rx_matches = array();
				// do some nasty string manipulations to restore the original letter case
				// this should work in most cases
				$rx_matches = explode('_', $arh_key);
				if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
					foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
					$arh_key = implode('-', $rx_matches);
				}
				$arh[$arh_key] = $val;
			}
		}
		return( $arh );
	}
}

require_once '../classes/Autoloader.php';

$db = new MySQLi(array(
	'host' => 'localhost',
	'user' => 'mamingorodok',
	'pass' => 'ZwzKrFkPj4G6',
	'name' => 'mamingorodok',
	'encode' => 'utf8'
));

$jsonrpc = new jsonRPC2Server();
$jsonrpc->registerClass(new Server($db));
$jsonrpc->registerUser('kokoc','sdf@edf21');
$jsonrpc->handle() or die('error rpc server');
