<?php

namespace App\Http\Controllers\Admin;

use App\Google;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Datatables;

class GoogleController extends AdminController
{

    public function __construct()
    {
        view()->share('type', 'googlegroups');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.googlegroups.index');
    }


    public function listGroups()
    {
		$google=new Google();
		$group_list=$google->getGoogleGroups();
        return view('admin.googlegroups.index', compact('group_list'));
    }

	 public function listGoogleUsers()
    {
		$google=new Google();
		$users_list=$google->getGoogleUsers();
		return view('admin.googleusers.index', compact('users_list'));
    }


}
