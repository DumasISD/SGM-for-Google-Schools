@extends('admin.layouts.default')
{{-- Web site Title --}}
@section('title') Groups::
@parent @endsection
@section('styles')
    @parent
<link rel="stylesheet" type="text/css" href="{{ asset("css/query-builder.default.min.css") }}">

@endsection

{{-- Content --}}
@section('main')
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
						 Smart Groups
					</h1>
                </div>
 </div>
 @if (isset($smartgroup))
    {!! Form::model($smartgroup, array('url' => url('admin/smartgroup') . '/' . $smartgroup->id. '/edit', 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
@else
    {!! Form::open(array('url' => url('admin/smartgroup'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
@endif
<!-- <form class="form-horizontal" method="post"
	action="@if (isset($smartgroup)){{ URL::to('admin/smartgroup' . $smartgroup->id . '/edit') }}@endif"
	autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> -->
	<div class="row">
	<div class="tab-content">
		<div class="tab-pane active" id="tab-general">
			<div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}">
				<div class="col-md-12">
					{!! Form::label('name', "Name", array('class' => 'col-md-2 control-label')) !!}
					<div class="col-md-5">
						{!! Form::text('name', null, array('class' => 'form-control')) !!}
						<span class="help-block">{{ $errors->first('name', ':message') }}</span>
					</div>
				</div>
			</div>
			 <div class="form-group  {{ $errors->has('googledomain_id') ? 'has-error' : '' }}">
					<div class="col-md-12">
							{!! Form::label('google_domain_id', "Google Domain", array('class' => 'col-md-2 control-label')) !!}
								<div class="col-md-5">
									 <select style="width: 100%" name="google_domain_id" id="google_domain_id" class="form-control">
										<option value="0">Select one</option>
										@foreach($googledomains as $domain)
										<option value="{{$domain->id}}"
											@if(!empty($smartgroup))
												@if($smartgroup->google_domain_id==$domain->id)
													selected="selected"
												@endif
											@endif
										 >{{$domain->name}}</option>
										@endforeach
									</select>
									<span class="help-block">{{ $errors->first('google_domain_id', ':message') }}</span>
								</div>
					</div>
		     </div>
			<div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
				<div class="col-md-12">
					{!! Form::label('email', trans("admin/smartgroup.email"), array('class' => 'col-md-2 control-label')) !!}
					<div class="col-md-5">
						{!! Form::text('email', null, array('class' => 'form-control')) !!}
						<span class="help-block">{{ $errors->first('email', ':message') }}</span>
					</div>
				</div>
			</div>
			<div class="form-group  {{ $errors->has('description') ? 'has-error' : '' }}">
				<div class="col-md-12">
					{!! Form::label('description', trans("admin/smartgroup.description"), array('class' => 'col-md-2 control-label')) !!}
					<div class="col-md-5">
						{!! Form::text('description', null, array('class' => 'form-control')) !!}
						<span class="help-block">{{ $errors->first('description', ':message') }}</span>
					</div>
				</div>
			</div>
			<div class="form-group  {{ $errors->has('google_group_id') ? 'has-error' : '' }}">
				<div class="col-md-12">
					{!! Form::label('google_group_id', trans("admin/smartgroup.google_group_id"), array('class' => 'col-md-2 control-label')) !!}
					(Leave blank if you want to create it in Google now)
					<div class="col-md-5">
						@if (isset($existing_google_group_id))
						{!! Form::text('google_group_id', $existing_google_group_id, array('class' => 'form-control')) !!}
						@else
						{!! Form::text('google_group_id', null, array('class' => 'form-control')) !!}
						@endif
						<span class="help-block">{{ $errors->first('google_group_id', ':message') }}</span>
					</div>
				</div>
			</div>
			<!-- <div class="form-group  {{ $errors->has('type') ? 'has-error' : '' }}">
			<div class="col-md-12">
				{!! Form::label('type', trans("admin/smartgroup.type"), array('class' => 'col-md-2 control-label')) !!}
				<div class="col-md-5">
					 {!! Form::select('type',[
						   '1' => 'Email Value',
						   '2' => 'Organization Unit (OU)',
						   '3' => 'Employee Type',
						   '4' => 'Department',
						   '5' => 'Cost Center',
						   '6' => 'Manager Email',
						   '7' => 'Employee Title'
						],@isset($smartgroup)? $smartgroup->type : '1',
						array('class' => 'form-control')) !!}
					<span class="help-block">{{ $errors->first('type', ':message') }}</span>
				</div>
			</div>
			</div> -->

			<div class="form-group  {{ $errors->has('type') ? 'has-error' : '' }}">
				<div class="col-md-12">
					{!! Form::label('type', "Smart Group Pattern Condition", array('class' => 'col-md-2 control-label')) !!}
					<div class="col-md-10">
							<div id="builder"></div>
							<div class="btn-group">
							<button class="btn btn-danger reset" type="button">Reset</button>
							</div>
							 @if(env('APP_ENV') !="production")
							<div class="btn-group">
							 <!--  <button class="btn btn-primary parse-sql" data-stmt="false" type="button">View SQL</button> -->
							  <button class="btn btn-primary parse-json" data-stmt="false" type="button">View Json</button>
							</div>
							@endif
					</div>
					 @if(env('APP_ENV') !="production")
					<!-- For reference and review sql statement -->
					<div id="result" class="hide">
					  <h3>Output</h3>
					  <pre></pre>
					</div>
					@endif
					<input type="hidden" id="pattern_condition" name="pattern_condition">
				</div>
			</div>

			<!-- 	<div class="form-group  {{ $errors->has('reg_exp') ? 'has-error' : '' }}">
			<div class="col-md-12">
				{!! Form::label('regexp', trans("admin/smartgroup.reg_exp"), array('class' => 'col-md-2 control-label')) !!}
				(Examples - Starts with: abc*   Ends with: *@dumasschools.net   Contains: *abc*def*   Exactly: abc)
				<div class="col-md-5">
					{!! Form::text('regexp', null, array('class' => 'form-control')) !!}
					<span class="help-block">{{ $errors->first('regexp', ':message') }}</span>
				</div>
			</div>
			</div> -->
		</div>
	</div>

     </div>
	<div class="form-group mt20">
		<div class="col-md-offset-2 col-md-6">
			<button type="submit" id="submit" class="btn btn-sm btn-success">
				<span class="glyphicon glyphicon-ok-circle"></span>
				@if (isset($smartgroup))
				    {{ trans("admin/modal.edit") }}
				@else
				    {{trans("admin/modal.create") }}
			     @endif
			</button>
			<a class="btn btn-sm btn-default" href="{{ url('admin/smartgroup') }}"> <span class="glyphicon glyphicon-remove-circle"></span> {{
				trans("admin/modal.back") }}</a>
		</div>
	</div>
	</div>
{!! Form::close() !!}
@endsection
{{-- Scripts --}}
@section('scripts')
    @parent
	<script src="{{ asset('js/bower_components/jquery-extendext/jQuery.extendext.min.js') }}"></script>
	<script src="{{ asset('js/bower_components/sql-parser/browser/sql-parser.js') }}"></script>
	<script src="{{ asset('js/query-builder.standalone.min.js') }}"></script>

    <script type="text/javascript">
	$(document).ready(function() {
	var rules_basic = {
	};

$('#builder').queryBuilder({
  plugins: ['bt-tooltip-errors'],

  filters: [{
    id: 'email_value',
    label: 'Email',
    type: 'string',
	operators: ['begins_with','ends_with','contains','equal', 'not_equal']
  }, {
    id: 'employee_type',
    label: 'Employee Type',
     type: 'string',
    operators: ['begins_with','ends_with','contains','equal', 'not_equal']
  },
  {
    id: 'department',
    label: 'Department',
    type: 'string',
	operators: ['begins_with','ends_with','contains','equal', 'not_equal']
  },{
    id: 'manager_email',
    label: 'Manager Email',
   type: 'string',
	operators: ['begins_with','ends_with','contains','equal', 'not_equal']
  }, {
    id: 'employee_title',
    label: 'Emplyee Title',
   type: 'string',
	operators: ['begins_with','ends_with','contains','equal', 'not_equal']
  }],

 // rules: rules_basic
});

//Display sql during edit view, get sql from table
 @if (isset($smartgroup) && $smartgroup->pattern_condition!="")
	 var sql_statement=<?php echo $smartgroup->pattern_condition;?>;
	 $('#builder').queryBuilder('setRules',sql_statement);
 @endif

$('#btn-reset').on('click', function() {
  $('#builder-basic').queryBuilder('reset');
});

// reset builder
$('.reset').on('click', function() {
  $('#builder').queryBuilder('reset');
  $('#result').addClass('hide').find('pre').empty();
});

// get rules
$('.parse-json').on('click', function() {
  $('#result').removeClass('hide')
    .find('pre').html(JSON.stringify(
      $('#builder').queryBuilder('getRules', {get_flags: true}),
      undefined, 2
    ));
});

$('.parse-sql').on('click', function() {
  var res = $('#builder').queryBuilder( 'getSQL', false, true);
  $('#result').removeClass('hide')
    .find('pre').html(
      res.sql + (res.params ? '\n\n' + JSON.stringify(res.params, undefined, 2) : '')
    );
});


$('#submit').on('click', function() {
   //var res = $('#builder').queryBuilder('getSQL', $(this).data('stmt'), false);
   //var sql=res.sql;
   var res =  $('#builder').queryBuilder('getRules',{get_flags: true});
   if($.isEmptyObject(res)){
	alert("Problem in pattern type selection");
	return false;
   }
   var json_string = JSON.stringify(res);
   $('#pattern_condition').val(json_string);
});
});
    </script>
@stop

