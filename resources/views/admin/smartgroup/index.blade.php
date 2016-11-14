@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') Groups::
@parent @endsection

@section('styles')
    @parent
    <link href="{{ asset("css/flags.css") }}" rel="stylesheet">
@endsection

{{-- Content --}}
@section('main')
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
						 Groups
					</h1>
                </div>
				 <div class="pull-right">
                <a href="{!!  url('admin/smartgroup/create') !!}"
                   class="btn btn-sm  btn-primary iframe"><span
                            class="glyphicon glyphicon-plus-sign"></span> {!!
				trans("admin/modal.new") !!}</a>
			 </div>
 </div>
    <table id="table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>{{ trans("admin/modal.name") }}</th>
            <th>{{ trans("admin/smartgroup.google_group_id") }}</th>
            <th>{{ trans("admin/smartgroup.type") }}</th>
            <th>{{ trans("admin/smartgroup.email") }}</th>
            <th>{{ trans("admin/smartgroup.google_domain") }}</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection

{{-- Scripts --}}
@section('scripts')
@endsection
