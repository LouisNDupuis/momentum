<?php

namespace trips;

class Trip {

	public $id;
	public $uid = 1; // AS we haven't implement any User or account, we'll use this default value
	public $name = "";
	public $destinations = [];
	
}
