<?php
	
namespace trips;

include( "data/Data.php" );
include( "trips/Flight.php" );
include( "trips/IMomentumController.php" );

use trips\Flight; 
use data\Data;
use trips\IMomentumController;

class FlightController implements IMomentumController {
	
	/**
	 * add a new Flight to a Trip
	 * 
	 * @param Trip $trip, the related Trip
	 * @param Flight[] $flights, the list flight
	 * @return bool
	 */
	 public function add( $trip, $flights ) {
		 $added = false;
		 if ( !empty( $flights ) ) {
			 $pdo = new Data();

			 foreach ( $flights as $f ) {
				 $new_flight = new Flight();
				 $new_flight->airport_from = $f['airport_from'];
				 $new_flight->airport_to = $f['airport_to'];
				 
				 $query = "INSERT INTO flight ( airport_from, airport_to ) VALUES ( {$new_flight->airport_from}, {$new_flight->airport_to} )";
				 $new_flight->id = $pdo->executeQuery( $query );
				 
				 $relation_query = "INSERT INTO trip_has_flight ( trip_id, flight_id ) VALUES ( {$trip->id}, {$new_flight->id} )";
				 $added = $pdo->executeQuery( $relation_query );
			 }
		 }
		 
		 return $added;
	}
	 
	/**
	 * remove a Flight from a Trip 
	 * will also removed the entry in the table of correspondences (trip_has_flight)
	 * 
	 * @param int $trip_id, the related Trip
	 * @param Array $flight, the flight information
	 * @return bool
	 */
	public function remove( $trip_id, $flight ) {
		$removed = false;
		if ( isset( $trip_id ) && $trip_id > 0 && isset( $flight ) ) {
			$pdo = new Data();
			if ( !is_object( $flight ) ) {
				$flight = $this->get( $flight['id'] );
			}
			$query = "DELETE FROM flight WHERE id = {$flight->id}";
			$q_removed = $pdo->executeQuery( $query, false );
			if ( $q_removed ) {
				$query2 = "DELETE FROM trip_has_flight WHERE trip_id = {$trip_id} AND flight_id = {$flight->id}";
				$removed = $pdo->executeQuery( $query2, false );
			}
		}
		
		return $removed;
	}
	
	/**
	 * get fligths Obj for Trip
	 *
	 * @param int $id the trip id
	 * @return array|bool
	 */
	public function get( $id ) {
		$flights = false;
		if ( is_int( $id ) ) {
		 	$query = "SELECT f.* FROM flight AS f LEFT JOIN trip_has_flight AS tf ON f.id = tf.flight_id WHERE tf.trip_id = ".$id;
		 	$pdo = new Data();
		 	$flights_info = $pdo->executeQueryAll( $query );
			if ( $flights_info ) {
				foreach ( $flights_info as $f ) {
					$flights[] = $this->hydrate( (array)$f );
				}
			}
		}
		return $flights;
	}
	 
	/**
	 * hydrate the object
	 *
	 * @param array $flight_info containing all he flights info
	 * @return Flight 
	 */
	private function hydrate( $flight_info ) {
		$flight = new Flight();
		$flight->id = $flight_info['id'];
		$flight->airport_from = $flight_info['airport_from'];
		$flight->airport_to = $flight_info['airport_to'];
		return $flight;
	} 
	
}
