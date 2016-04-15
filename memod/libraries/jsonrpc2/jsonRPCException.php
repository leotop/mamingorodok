<?php
/**
 * Modified version by: BeforyDeath
 * Initial version created on: 10.01.14 18:57
 */

namespace libraries\jsonrpc2;


class jsonRPCException extends \Exception
{
	private $_errorData;
	public function __construct($message, $code = 0, \Exception $previous = null, $errorData = Array('no data')) {
		parent::__construct($message, $code, $previous);
		$this->_errorData = $errorData;
	}

	public function _getErrorData() {
		return $this->_errorData;
	}
}