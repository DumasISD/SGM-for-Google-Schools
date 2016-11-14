<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use App\ArticleCategory;
use App\User;
use App\SmartGroup;


class DashboardController extends AdminController {

    public function __construct()
    {
        parent::__construct();
        view()->share('type', '');
    }

	public function index()
	{
        $title = "Dashboard";


        $newscategory = ArticleCategory::count();
        $smartgroup = Smartgroup::count();
        $users = User::count();

		return view('admin.dashboard.index',  compact('title','smartgroup','users'));
	}
}