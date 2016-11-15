@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') Google Users::
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
						 Google Users
					</h1>
                </div>
 </div>
<div class="row">
Error - you must setup a google domain before you can access this page.
 </div>

@endsection

{{-- Scripts --}}
@section('scripts')
@endsection
