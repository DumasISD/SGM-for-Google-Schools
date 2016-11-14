@extends('admin.layouts.modal')
{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab"> {{
			trans("admin/modal.general") }}</a></li>
</ul>
<!-- ./ tabs -->
@if (isset($smartgroup))
    {!! Form::model($smartgroup, array('url' => url('admin/smartgroup') . '/' . $smartgroup->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
@else
    {!! Form::open(array('url' => url('admin/smartgroup'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
@endif
	<div class="tab-content">
		<div class="tab-pane active" id="tab-general">
			<div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}">
				{!! Form::label('name', "Name", array('class' => 'control-label')) !!}
				<div class="controls">
					{!! Form::text('name', null, array('class' => 'form-control')) !!}
					<span class="help-block">{{ $errors->first('name', ':message') }}</span>
				</div>
			</div>
			<div class="form-group  {{ $errors->has('googledomain_id') ? 'has-error' : '' }}">
				{!! Form::label('google_domain_id', "Google Domain", array('class' => 'control-label')) !!}
				<div class="controls">
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
				</div>
			</div>

			<div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
				{!! Form::label('email', trans("admin/smartgroup.email"), array('class' => 'control-label')) !!}
				<div class="controls">
					{!! Form::text('email', null, array('class' => 'form-control')) !!}
					<span class="help-block">{{ $errors->first('email', ':message') }}</span>
				</div>
			</div>
			<div class="form-group  {{ $errors->has('description') ? 'has-error' : '' }}">
				{!! Form::label('description', trans("admin/smartgroup.description"), array('class' => 'control-label')) !!}
				<div class="controls">
					{!! Form::text('description', null, array('class' => 'form-control')) !!}
					<span class="help-block">{{ $errors->first('description', ':message') }}</span>
				</div>
			</div>
			<div class="form-group  {{ $errors->has('google_group_id') ? 'has-error' : '' }}">
				{!! Form::label('google_group_id', trans("admin/smartgroup.google_group_id"), array('class' => 'control-label')) !!}
	(Leave blank if you want to create it in Google now)
				<div class="controls">
                    @if (isset($existing_google_group_id))
					{!! Form::text('google_group_id', $existing_google_group_id, array('class' => 'form-control')) !!}
                    @else
					{!! Form::text('google_group_id', null, array('class' => 'form-control')) !!}
                    @endif
					<span class="help-block">{{ $errors->first('google_group_id', ':message') }}</span>
				</div>
			</div>
			<div class="form-group  {{ $errors->has('type') ? 'has-error' : '' }}">
				{!! Form::label('type', trans("admin/smartgroup.type"), array('class' => 'control-label')) !!}
				<div class="controls">
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

			<div class="form-group  {{ $errors->has('reg_exp') ? 'has-error' : '' }}">
				{!! Form::label('regexp', trans("admin/smartgroup.reg_exp"), array('class' => 'control-label')) !!}
(Examples - Starts with: abc*   Ends with: *@dumasschools.net   Contains: *abc*def*   Exactly: abc)
				<div class="controls">
					{!! Form::text('regexp', null, array('class' => 'form-control')) !!}
					<span class="help-block">{{ $errors->first('regexp', ':message') }}</span>
				</div>
			</div>

		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<button type="reset" class="btn btn-sm btn-warning close_popup">
				<span class="glyphicon glyphicon-ban-circle"></span> {{
				trans("admin/modal.cancel") }}
			</button>
			<button type="reset" class="btn btn-sm btn-default">
				<span class="glyphicon glyphicon-remove-circle"></span> {{
				trans("admin/modal.reset") }}
			</button>
			<button type="submit" class="btn btn-sm btn-success">
				<span class="glyphicon glyphicon-ok-circle"></span>
				@if (isset($smartgroup))
				    {{ trans("admin/modal.edit") }}
				@else
				    {{trans("admin/modal.create") }}
			     @endif
			</button>
		</div>
	</div>
{!! Form::close() !!}
@endsection
