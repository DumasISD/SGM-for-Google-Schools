<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Input;
use App\GoogleDomain;
use App\Http\Requests\Admin\GoogleDomainRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use Log;

class GoogleDomainController extends AdminController {

    public function __construct()
    {
        view()->share('type', 'googledomain');
    }
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        // Show the page
        Log::info('googledomain controller', ['context' => "index"]);

        return view('admin.googledomain.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
       // Show the page
        return view('admin/googledomain/create_edit');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(GoogleDomainRequest $request)
	{
        Log::info('googledomain controller', ['context' => "store"]);
        Log::info('googledomain controller request', ['context' => $request]);

        $domain = new GoogleDomain($request->all());
        Log::info('googledomain controller', ['context' => $domain]);
        $domain -> save();
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(GoogleDomain $googledomain)
	{
        return view('admin/googledomain/create_edit',compact('googledomain'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(GoogleDomainRequest $request, GoogleDomain $googledomain)
	{
        $googledomain -> update($request->all());
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function delete(GoogleDomain $googledomain)
    {
        // Show the page
        return view('admin/googledomain/delete', compact('googledomain'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy(GoogleDomain $googledomain)
    {
        $googledomain->delete();
    }


    /**
     * Show a list of all the domain posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
Log::info('googledomain controller', ['context' => "data"]);
        $googledomains = GoogleDomain::all();
Log::info('googledomain controller', ['context' => $googledomains]);

        $googledomains = GoogleDomain::whereNull('google_domains.deleted_at')
            ->orderBy('google_domains.name', 'ASC')
			->get()
			->map(function ($googledomain) {
				return [
					'id' => $googledomain->id,
					'name' => $googledomain->name,

				];
			});
Log::info('googledomain controller', ['context' => $googledomains]);
        return Datatables::of($googledomains)

            ->add_column('actions', '<a href="{{{ url(\'admin/googledomain/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span> {{ trans("admin/modal.edit") }}</a>
                    <a href="{{{ url(\'admin/googledomain/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> {{ trans("admin/modal.delete") }}</a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
            ->remove_column('id')

            ->make();
    }

}
