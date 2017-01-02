<?php
namespace App\Helpers;

class Helper
{

	public static function contains($field, $value) {
	  return preg_match("/$value/", $field);
	}


	public static function begins_with($field, $value) {
		return preg_match("/^$value/", $field);
	 }

	public static function ends_with($field, $value) {
		 return preg_match("/${value}$/", $field);
	 }
 }


?>
