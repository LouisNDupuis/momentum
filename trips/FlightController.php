<?php
	
namespace trips;

include( "data/Data.php" );
include( "trips/Flight.php" );

use trips\Flight; 
use data\Data;


class FlightController {
	
	/**
	 * add a new Flight to a Trip
	 * 
	 * @param Trip $trip, the related Trip
	 * @param Flight $flight, the flight
	 * @return bool
	 */
	 public function addFlight( Trip &$trip, Flight &$flight ) {
		 
	 }
	 
	/**
	 * add a new Flight to a Trip
	 * 
	 * @param Trip $trip, the related Trip
	 * @param Flight $flight, the flight
	 * @return bool
	 */
	public function removeFlight( Trip &$trip, Flight &$flight ) {
		
	}
	
	/**
	 * get fligths Obj for Trip
	 *
	 * @param int $id the trip id
	 * @return array|bool
	 */
	public function getFlightsForTrip( $id ) {
		$flights = false;
		if ( is_int( $id ) ) {
		 	$query = "SELECT f.* FROM flight AS f LEFT JOIN trip_has_flight AS tf ON f.id = tf.flight_id WHERE tf.trip_id = ".$id;
		 	$pdo = new Data();
		 	$flights_info = $pdo->executeQuery( $query );
			if ( $flights_info ) {
				foreach ( $flights_info as $f ) {
					$flights[] = $this->hydrate( $f );
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