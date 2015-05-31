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
	public function executeQueryfetch( $query ) {
		$queryExecuted = false;

		$pdo = $this->connect();
		if ( $pdo ) {
			try {
				$queryExecuted = $pdo->query( $query )->fetch( PDO::FETCH_OBJ );
			} catch ( PDOException $e ) {
				echo $e->getMessage();
			}
			$this->close( $pdo );
		}

		return $queryExecuted;
	}
	
	/**
	 * Execute a given query for All entries
	 *
	 * @param String $query : the query to be executed
	 * @return bool
	 */
	public function executeQueryAll( $query ) {
		$queryExecuted = false;

		$pdo = $this->connect();
		if ( $pdo ) {
			try {
				$queryExecuted = $pdo->query( $query )->fetchAll( PDO::FETCH_OBJ );
			} catch ( PDOException $e ) {
				echo $e->getMessage();
			}
			$this->close( $pdo );
		}

		return $queryExecuted;
	}
	
	/**
	 * Insert in db
	 *
	 * @param $query the query!
	 * @param
	 * @return int|bool the last id inserted, result query otherwise
	 */ 
	 public function executeQuery( $query, $return_id = true ) {
		$queryExecuted = false;

		$pdo = $this->connect();
		if ( $pdo ) {
			try {
				$queryToExecute = $pdo->prepare( $query );
				$queryExec = $queryToExecute->execute();
				
				if ( $queryExec && $return_id ) {
					$queryExecuted = $pdo->lastInsertId();
				} else if ( $queryExec && !$return_id ) {
					$queryExecuted = $queryExec;
				}
			} catch ( PDOException $e ) {
				echo $e->getMessage();
			}
		}
		$this->close( $pdo );
		
		return $queryExecuted;
	 }

}
