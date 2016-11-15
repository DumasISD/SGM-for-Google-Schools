<?php

namespace App\Http\Controllers\Admin;

use App\Google;
use App\SmartGroup;
use App\GoogleDomain;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Datatables;
use Log;

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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getSmartGroupCreate($existing_google_group_id)
	{
       // Show the page
		$googledomains = GoogleDomain::all();
        return view('admin/googlegroups/create_edit',compact('googledomains','existing_google_group_id'));
	}

	public function getSmartGroupEdit(SmartGroup $smartgroup)
	{
	   $googledomains = GoogleDomain::all();
        return view('admin/googlegroups/create_edit',compact('smartgroup','googledomains'));
	}

    public function listGroups()
    {
        $googledomains = GoogleDomain::all();
        $c=count($googledomains);
 Log::info('googledomain controller count', ['context' => $c]);
        if (count($googledomains) == 0) {
            return view('admin.googlegroups.none');
            }
        $domain = $googledomains[0];
        $selected_domain_id = $domain->id;
 Log::info('googledomain controller domain', ['context' => $selected_domain_id]);
 Log::info('googledomain controller domain', ['context' => $domain]);

		$google=new Google();
		$group_list=$google->getGoogleGroups($domain->name);
     Log::info('googledomain controller group_list', ['context' => $group_list]);
        $glist=array();
        foreach ($group_list as $group) {
            $smart = SmartGroup::where("google_group_id","=",$group->getId())->exists();
            $id = 0;
            if ($smart == true) {
                 $smartgroup = SmartGroup::where("google_group_id","=",$group->getId())->get()->first();
     Log::info('googledomain controller smartgroup', ['context' => $smartgroup]);
                $id = $smartgroup->id;
     Log::info('googledomain controller id', ['context' => $id]);
                   }
            $glist[] = array("google_group_id"=>$group->getId(), "name"=>$group->getName(), "smart"=>$smart, "id"=>$id, "email"=>$group->getEmail());
        }
        return view('admin.googlegroups.index', compact('glist','googledomains','selected_domain_id'));
    }

    public function listGroups2($selected_domain_id)
    {
        $googledomains = GoogleDomain::all();
        foreach ($googledomains as $domain) {
            if ($domain->id == $selected_domain_id) {
                $domain_name = $domain->name;
                break;
            }
        }

		$google=new Google();
		$group_list=$google->getGoogleGroups($domain_name);
        $glist=array();
        foreach ($group_list as $group) {
     Log::info('googledomain controller group_list', ['context' => $group->getEmail()]);
            $smart = SmartGroup::where("google_group_id","=",$group->getId())->exists();
            $id = 0;
            if ($smart == true) {
                 $smartgroup = SmartGroup::where("google_group_id","=",$group->getId())->get()->first();
     Log::info('googledomain controller smartgroup', ['context' => $smartgroup]);
                $id = $smartgroup->id;
     Log::info('googledomain controller id', ['context' => $id]);
                   }
            $glist[] = array("google_group_id"=>$group->getId(), "name"=>$group->getName(), "smart"=>$smart, "id"=>$id, "email"=>$group->getEmail());
        }
        return view('admin.googlegroups.index', compact('glist','googledomains','selected_domain_id'));
    }

	 public function listGoogleUsers()
    {
        $googledomains = GoogleDomain::all();
       $c=count($googledomains);
       Log::info('googledomain controller count', ['context' => $c]);
       if (count($googledomains) == 0) {
            return view('admin.googleusers.none');
            }

        $domain = $googledomains[0];
        $selected_domain_id = $domain->id;

		$google=new Google();
		$users_list=$google->getGoogleUsers($domain->name);
		return view('admin.googleusers.index', compact('users_list','googledomains','selected_domain_id'));
    }

    public function listGoogleUsers2($selected_domain_id)
    {
        $googledomains = GoogleDomain::all();
        foreach ($googledomains as $domain) {
            if ($domain->id == $selected_domain_id) {
                $domain_name = $domain->name;
                break;
            }
        }

        $google=new Google();
        $users_list=$google->getGoogleUsers($domain_name);
		return view('admin.googleusers.index', compact('users_list','googledomains','selected_domain_id'));
    }

}
