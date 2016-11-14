<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SmartGroup extends Model {


	protected $table = "smart_groups";

	//This attribute protect against mass assignment
	protected $guarded  = array('id');


	/**
	 * Get the google domain name.
	 *
	 * @return Language
	 */
	public function google_domains()
	{
		return $this->belongsTo(GoogleDomain::class,'google_domain_id');
	}


}
