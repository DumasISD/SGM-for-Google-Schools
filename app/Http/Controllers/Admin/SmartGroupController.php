<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Input;
use App\SmartGroup;
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
       // Show the page
        return view('admin/smartgroup/create_edit');
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

        $group = new SmartGroup($request->all());
        ##$group -> user_id = Auth::id();
        $group->smart=1;
        $group->google_group_id=$id;
        Log::info('smartgroup controller', ['context' => $group]);
        $group -> save();
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(SmartGroup $smartgroup)
	{
        return view('admin/smartgroup/create_edit',compact('smartgroup'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SmartGroupRequest $request, SmartGroup $smartgroup)
	{
        #$smartgroup -> user_id_edited = Auth::id();
        $smartgroup -> update($request->all());
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
        $smartgroups = SmartGroup::whereNull('smart_groups.deleted_at')
            ->orderBy('smart_groups.name', 'ASC')
			->get()
			->map(function ($smartgroup) {
				return [
					'id' => $smartgroup->id,
					'name' => $smartgroup->name,
					'google_group_id' => $smartgroup->google_group_id,
					'type' => $smartgroup->type,
					'email' => $smartgroup->email,

				];
			});
Log::info('smartgroup controller', ['context' => $smartgroups]);
        return Datatables::of($smartgroups)

			 ->edit_column('type', '@if ($type=="1") Email @elseif ($type=="2") Org Unit @elseif ($type=="3") Employee Type @elseif ($type=="4") Department @elseif ($type=="5") Cost Center @elseif ($type=="6") Manager Email  @elseif ($type=="7") Employee Title @else  Custom  @endif')
            ->add_column('actions', '<a href="{{{ url(\'admin/smartgroup/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
                    <a href="{{{ url(\'admin/smartgroup/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> {{ trans("admin/modal.delete") }}</a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
            ->remove_column('id')

            ->make();
    }

}
