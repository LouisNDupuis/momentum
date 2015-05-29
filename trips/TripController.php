<?php 
	
namespace trips;

include( "trips/Trip.php" );
include( "trips/FlightController.php" );

use trips\Trip; 
use trips\FlightController;
use data\Data;

class TripController {

	/**
	 * get a Trip
	 *
	 * @param int $id the Trip id
	 * @return Trip|bool
     */
	 public function getTrip( $id ) {
		 $trip = false;
		 
		 if ( isset( $id ) && is_int( $id ) ) {
			 $query = "SELECT * FROM trip WHERE id = ".$id;
			 $pdo = new Data();
			 $trip_info = $pdo->executeQuery( $query );
			 $trip = $this->hydrate( $trip_info );
		 } 
		 
		 return $trip; 
	 }

	/**
	 * Add a new Trip
	 *
	 * @param Trip $trip the new trip
	 * @return bool
	 */
	public function addTrip( Trip &$trip, $destinations ) {
		
	}
	
	/**
	 * Update an existing trip
	 */
	 public function editTrip( Trip &$trip, $destinations ) {
		 $added = false;
		
		if (  is_array( $destinations ) ) {
			$queryupdateTrip = "UPDATE trip SET id = {$trip->id}, name = '{$trip->name}', uid = {$this->uid} WHERE id = {$trip->id}";
			$pdo = new Data();
			$trip = $pdo->executeQuery( $query );
			foreach ( $destinations as $d ) {
				
			}
		}
		
		return $added;
	 }
	
	/**
	 * delete an entry
	 *
	 * @return bool
	 */
	public function removeTrip( Trip &$trip ) {
		
	}
	
	/**
	 * hydrate object
	 */
	private function hydrate( $trip_info ) {
		 $trip = new Trip();
		 $trip->id = $trip_info->id;
		 $trip->name = $trip_info->name;
		 
		 $flightCtrl = new FlightController();
		 $flights = $flightCtrl->getFlightsForTrip( (int)$trip->id );
		 if ( $flights ) {
			 $trip->$destinations = $flights;
		 }
		 return $trip;
	 }
	
}
