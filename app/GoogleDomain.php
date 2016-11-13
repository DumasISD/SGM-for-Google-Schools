<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class GoogleDomain extends Model {


	protected $table = "google_domains";

	//This attribute protect against mass assignment
	protected $guarded  = array('id');


}
