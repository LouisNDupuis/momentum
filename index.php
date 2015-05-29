<?php

include( "trips/TripController.php" );

use trips\TripController;
	
echo "ok";	

// get
$trip = new TripController();
$currentTrip = $trip->getTrip( 1 );

var_dump( $currentTrip );

echo "done";