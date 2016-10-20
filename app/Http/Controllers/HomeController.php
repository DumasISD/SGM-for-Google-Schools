<?php

namespace App\Http\Controllers;

use App\Article;
use App\Google;
use App\PhotoAlbum;
use DB;




class HomeController extends Controller {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		/*$var= new Google();
		$test=$var->getUsers();
		echo "<prE>";
		print_R($test);
		die;*/

		return view('pages.home', compact('articles', 'photoAlbums'));
	}


	public function getUsers()
	{
		$google=new Google();
		$users_list=$google->getGoogleUsers();
		return view('pages.users', compact('users_list'));
	}


	public function getUserGroups()
	{
		$google=new Google();
		$group_list=$google->getGoogleGroups();
		return view('pages.groups', compact('group_list'));
	}

}