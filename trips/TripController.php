<?php 
	
namespace trips;

include( "trips/Trip.php" );
include( "trips/FlightController.php" );

use trips\Trip; 
use trips\FlightController;
use data\Data;
use Exception;

class TripController implements IMomentumController {

	/**
	 * get a Trip
	 *
	 * @param int $id the Trip id
	 * @return Trip|bool
     */
	 public function get( $id ) {
		 $trip = false;
		 
		 if ( isset( $id ) && is_int( $id ) ) {
			 $query = "SELECT * FROM trip WHERE id = ".$id;
			 $pdo = new Data();
			 $trip_info = $pdo->executeQueryfetch( $query );
			 $trip = $this->hydrate( $trip_info );
		 } 
		 
		 return $trip; 
	 }

	/**
	 * Add a new Trip 
	 *
	 * @param Array $trip the new Trip
	 * @param Array $destinations all the destinations related to the Trip 
	 * @return bool
	 */
	public function add( $trip, $destinations ) {
		$added = false;
		if ( isset( $trip['uid'] ) && !empty( $trip['uid'] ) && 
			 isset( $trip['name'] ) && !empty( $trip['name'] ) &&
			 isset( $destinations ) && !empty( $destinations ) 
		) {
			try {
				$new_trip = new Trip();
				$new_trip->uid = $trip['uid'];
				$new_trip->name = $trip['name'];

				$pdo = new Data();
				$query = "INSERT INTO trip ( uid, name ) VALUES ( {$new_trip->uid}, '{$new_trip->name}' )";
				$new_trip->id = $pdo->executeQuery( $query );
				if ( $new_trip->id ) {
					$flightCtrl = new FlightController();
					$added = $flightCtrl->add( $new_trip, $destinations );
				} 
			} catch( Exception $e ) {
				echo $e->getMessage();		
				$this->remove( $new_trip );
			}
		} 
		
		return $added;
	}
	
	/**
	 * Update an existing trip
	 *
	 * @param int|Trip the trip to edit
	 */
	public function editTrip( $trip ) {
		$editted = false;
		
		if ( !( $trip instanceof Trip ) ) {
			$trip = $this->get( $trip['id'] );
		}

		if ( is_object( $trip ) ) {
			$pdo = new Data();
			$queryupdateTrip = "UPDATE trip SET name = '{$trip->name}', uid = {$trip->uid} WHERE id = {$trip->id}";
			$editted = $pdo->executeQuery( $queryupdateTrip, false );
		}
		
		return $editted;
	 }
	
	/**
	 * delete an entry
	 *
	 * @param Trip|array $trip the trip to remove
	 * @return bool
	 */
	public function remove( $trip ) {
		$removed = false;
		if ( !( $trip instanceof trips\Trip ) ) {
			$trip = $this->get( $trip['id'] );
		}
		
		if ( is_object( $trip ) ) {
			$pdo = new Data();
			$query = "DELETE FROM trip WHERE id = ".$trip->id;
			$q_removed = $pdo->executeQuery( $query, false );
			if ( $q_removed ) {
				$flightCtrl = new FlightController();
				foreach ( $trip->destinations as $f ) {
					$removed = $flightCtrl->remove( $trip->id, $f );
				}
			}
		}
		
		return $removed;
	}
	
	/**
	 * hydrate object
	 */
	private function hydrate( $trip_info ) {
		 $trip = new Trip();
		 $trip->id = $trip_info->id;
		 $trip->name = $trip_info->name;
		 
		 $flightCtrl = new FlightController();
		 $flights = $flightCtrl->get( (int)$trip->id );
		 if ( $flights ) {
			 foreach ( $flights as $f ) {
			 	$trip->destinations[] = $f;
			 }
		 }
		 return $trip;
	 }
	
}
