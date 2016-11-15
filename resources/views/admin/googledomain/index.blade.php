@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') Google Domains::
@parent @endsection

@section('styles')
    @parent
    <link href="{{ asset("css/flags.css") }}" rel="stylesheet">
@endsection

{{-- Content --}}
@section('main')
@include('notifications')
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
						 Google Domains
					</h1>
                </div>
				 <div class="pull-right">
                <a href="{!!  url('admin/googledomain/create') !!}"
                   class="btn btn-sm  btn-primary iframe"><span
                            class="glyphicon glyphicon-plus-sign"></span> {!!
				trans("admin/modal.new") !!}</a>
            </div>
 </div>

    <table id="table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>{{ trans("admin/modal.name") }}</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
			$('body').on('click', '.delete_domain', function(e){
                if(confirm("Are you sure to delete the domain?"))
                   return true;
                return false;
            });
		 });
    </script>
@stop

