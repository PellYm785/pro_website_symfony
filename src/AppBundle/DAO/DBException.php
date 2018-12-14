<?php

namespace AppBundle\DAO;

use \Exception;

class DBException extends Exception {
	
	public function __construct(string $msg) {
		$this->message = $msg;
		echo $msg . '<br />';
		echo $this->getTraceAsString();
		//exit;
	}
	
}

