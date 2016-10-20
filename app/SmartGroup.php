<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SmartGroup extends Model {


	protected $table = "smart_groups";

	//This attribute protect against mass assignment
	protected $guarded  = array('id');


}
