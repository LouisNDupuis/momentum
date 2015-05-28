<?php

namespace data;

use PDO;
use PDOException;
use data\Credential;

class Data {

	/**
	 * create a connection to the databse
	 *
	 * @return bool|PDO
	 */
	protected function connect() {
		$dbh = false;
		try {
			$dbh = new PDO( 'mysql:host='.Credential::DB_HOST.';dbname='.Credential::DB_NAME, Credential::DB_USER, Credential::DB_PASS );
		} catch ( PDOException $e ) {
			return false;
		}
		return $dbh;
	}

	/**
	 * close connection with the database
	 */
	protected function close( PDO &$connection ) {
		$connection = null;
	}

}
