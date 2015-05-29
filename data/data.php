<?php

namespace data;

include( "data/Credential.php" );

use PDO;
use PDOException;
use data\Credential;


/**
 * Really Basic Class For DB Handling
 */
class Data {

	/**
	 * create a connection to the databse
	 *
	 * @return bool|PDO
	 */
	protected function connect() {
		try {
			$pdo = new PDO( 'mysql:host='.Credential::DB_HOST.';dbname='.Credential::DB_NAME, Credential::DB_USER, Credential::DB_PASS );
		} catch ( PDOException $e ) {
			$pdo = false;
		}
		return $pdo;
	}

	/**
	 * close connection with the database
	 */
	protected function close( PDO &$connection ) {
		$connection = null;
	}

	/**
	 * Execute a given query
	 *
	 * @param String $query : the query to be executed
	 * @return bool
	 */
	public function executeQuery( $query ) {
		$queryExecuted = false;

		$pdo = $this->connect();
		if ( $pdo ) {
			$queryExecuted = $pdo->query( $query )->fetch( PDO::FETCH_OBJ );
			$this->close( $pdo );
		}

		return $queryExecuted;
	}

}
