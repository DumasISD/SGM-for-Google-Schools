<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Input;
use App\SmartGroup;
use App\GoogleDomain;
use App\Http\Requests\Admin\SmartGroupRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use Log;
use App\Google;

class SmartGroupController extends AdminController {

    public function __construct()
    {
        view()->share('type', 'smartgroup');
    }
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        // Show the page
        Log::info('smartgroup controller', ['context' => "index"]);

        return view('admin.smartgroup.index');
	}

	public function queryBuilder()
	{
        return view('admin.smartgroup.query_builder');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
       // Show the page
	$googledomains = GoogleDomain::all();
        return view('admin/smartgroup/create_edit',compact('googledomains'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SmartGroupRequest $request)
	{
        Log::info('smartgroup controller', ['context' => "store"]);
        Log::info('smartgroup controller request', ['context' => $request]);

        if (!$request->google_group_id || $request->google_group_id=="") {
            $google = new Google();

            $email = $request->email;
                Log::info('smartgroup controller', ['context' => $email]);
            $name = $request->name;
                Log::info('smartgroup controller', ['context' => $name]);
            $desc = $request->description;
                Log::info('smartgroup controller', ['context' => $desc]);
            $results=$google->addGroup($email, $name, $desc);
            var_dump($results);
            $id = $results->getId();
            }
        else {
            $id = $request->google_group_id;
        }
        $group = new SmartGroup();
        ##$group -> user_id = Auth::id();
        $group->smart=1;
		$group->name=$request->name;
        $group->google_domain_id=$request->google_domain_id;
        $group->email=$request->email;
        $group->description=$request->description;
        $group->google_group_id=$request->google_group_id;
       //$group->type=$request->type;
       // $group->regexp=$request->regexp;
        $group->pattern_condition=$request->pattern_condition;
        $group->google_group_id=$id;
        Log::info('smartgroup controller', ['context' => $group]);
        $group -> save();
	    return redirect('admin/smartgroup')->with('success', 'Smartgroup Created Successfully');
	}

	public function saveSmartGroup(SmartGroupRequest $request)
	{
        if (!$request->google_group_id || $request->google_group_id=="") {
            $google = new Google();

            $email = $request->email;
                Log::info('smartgroup controller', ['context' => $email]);
            $name = $request->name;
                Log::info('smartgroup controller', ['context' => $name]);
            $desc = $request->description;
                Log::info('smartgroup controller', ['context' => $desc]);
            $results=$google->addGroup($email, $name, $desc);
            var_dump($results);
            $id = $results->getId();
            }
        else {
            $id = $request->google_group_id;
        }

        $group = new SmartGroup($request->all());
        ##$group -> user_id = Auth::id();
        $group->smart=1;
        $group->google_group_id=$id;
        Log::info('smartgroup controller', ['context' => $group]);
        $group -> save();
		return redirect('admin/google-groups')->with('success', 'Smart Group Inserted Successfully');
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(SmartGroup $smartgroup)
	{
		$googledomains = GoogleDomain::all();
        return view('admin/smartgroup/create_edit',compact('smartgroup','googledomains'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SmartGroupRequest $request,$id)
	{
        #$smartgroup -> user_id_edited = Auth::id();
		$smartgroup = SmartGroup::find($id);
        $smartgroup->name=$request->name;
        $smartgroup->google_domain_id=$request->google_domain_id;
        $smartgroup->email=$request->email;
        $smartgroup->description=$request->description;
        $smartgroup->google_group_id=$request->google_group_id;
        //$smartgroup->type=$request->type;
        //$smartgroup->regexp=$request->regexp;
        $smartgroup->pattern_condition=$request->pattern_condition;
		$smartgroup -> save();
		return redirect('admin/smartgroup')->with('success', 'Smartgroup Updated Successfully');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function updateSmartGroup(SmartGroupRequest $request, SmartGroup $smartgroup)
	{
        $smartgroup -> update($request->all());
		return redirect('admin/google-groups')->with('success', 'Smart Group Updated Successfully');
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function delete(SmartGroup $smartgroup)
    {
        // Show the page
        return view('admin/smartgroup/delete', compact('smartgroup'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy(SmartGroup $smartgroup)
    {
        $smartgroup->delete();
    }


    /**
     * Show a list of all the groups posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
Log::info('smartgroup controller', ['context' => "data"]);
        $googledomains = GoogleDomain::all();
        $d=array();
        foreach ($googledomains as $domain) {
            $d[$domain->id] = $domain->name;
            }
Log::info('smartgroup controller', ['d' => $d]);
		$smartgroups = SmartGroup::with('google_domains')
			->whereNull('smart_groups.deleted_at')
            ->orderBy('smart_groups.name', 'ASC')
			->get()
			->map(function ($smartgroup) {
				return [
					'id' => $smartgroup->id,
					'name' => $smartgroup->name,
					'google_group' => $smartgroup->google_group_id,
					'type' => $smartgroup->type,
					'email' => $smartgroup->email,
					'google_domain' =>isset($smartgroup->google_domains) ? $smartgroup->google_domains->name : "",

				];
			});
Log::info('smartgroup controller', ['context' => $smartgroups]);
        return Datatables::of($smartgroups)
			 ->edit_column('type', '@if ($type=="1") Email @elseif ($type=="2") Org Unit @elseif ($type=="3") Employee Type @elseif ($type=="4") Department @elseif ($type=="5") Cost Center @elseif ($type=="6") Manager Email  @elseif ($type=="7") Employee Title @else  Custom  @endif')
            ->add_column('actions', '<a href="{{{ url(\'admin/smartgroup/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
                    <a href="{{{ url(\'admin/smartgroup/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> {{ trans("admin/modal.delete") }}</a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
            ->remove_column('id')

            ->make();
    }

}
