<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use App\ArticleCategory;
use App\User;


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
        $users = User::count();

		return view('admin.dashboard.index',  compact('title','news','newscategory','photo','photoalbum','users'));
	}
}