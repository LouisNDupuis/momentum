<?php
	
namespace trips;
	
interface IMomentumController {
	
	public function get( $id );
	
	public function add( $obj1, $rel );
	
}