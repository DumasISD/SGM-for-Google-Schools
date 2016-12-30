<?php
namespace App\Helpers;

class Helper
{

	function contains($field, $value) {
	  return preg_match("/$value/", $field);
	}


	function begins_with($field, $value) {
		return preg_match("/^$value/", $field);
	 }

	function ends_with($field, $value) {
		 return preg_match("/${value}$/", $field);
	 }
 }


?>
