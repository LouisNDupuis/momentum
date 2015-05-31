<!doctype html>
<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <title>Momentum test</title>
	</head>
	<body>
		<h1>This is all simulations, for the purpose of the test ! :)</h1>
		<hr/>
<?php

include( "trips/TripController.php" );
use trips\TripController;

$op = isset( $_GET['op'] ) ? $_GET['op'] : null;
$id = isset( $_GET['id'] ) ? $_GET['id'] : 1;
switch ( $op ) {
	case 'view' : $trip = new TripController();
				  $currentTrip = $trip->get( (int)$id );
				  var_dump( $currentTrip );
		break;
		
	case 'add' : // lets simulate a '$_POST'' here
				 $newTripArray = $newDestinationsArray = [];
				 $newTripArray['uid'] = 1; 
				 $newTripArray['name'] = "My Super Trip ".rand();
				 $newDestinationsArray[0]['airport_from'] = 1;
				 $newDestinationsArray[0]['airport_to'] = 2;
				 $newDestinationsArray[1]['airport_from'] = 2;
				 $newDestinationsArray[1]['airport_to'] = 3;
				 $tripCtrl = new TripController();
				 $newTrip = $tripCtrl->add( $newTripArray, $newDestinationsArray );
				 var_dump( $newTrip );
		break;
		
	case 'edit' : // again, lets simulate a '$_POST'' here
				  $editedTripArray = [];
				  $editedTripArray['id'] = 2; 
				  $editedTripArray['uid'] = 1; 
				  $editedTripArray['name'] = "My Super Trip Edited ".rand();
				  $tripCtrl = new TripController();
				  $editedTrip = $tripCtrl->editTrip( $editedTripArray );
				  var_dump( $editedTrip );
		break;
		
	case 'delete' : $removeArray = [];
					$removeArray['id'] = 3;
					$tripCtrl = new TripController();
				  	$removedTrip = $tripCtrl->remove( $removeArray );
				    var_dump( $removedTrip );
		break;
		
	default : $link = "<a href='index.php?op=%s&id=%s'>%s</a><br/>"; 
			  echo vsprintf( $link, [ 'view', '1', 'view' ] );
			  echo vsprintf( $link, [ 'add', '1', 'add' ] );
			  echo vsprintf( $link, [ 'edit', '1', 'edit' ] );
			  echo vsprintf( $link, [ 'delete', '1', 'delete' ] );
}

?>
		<hr/>
</body>
</html>
