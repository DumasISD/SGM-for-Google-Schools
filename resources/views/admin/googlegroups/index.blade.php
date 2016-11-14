@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/googlegroups.googlegroups") !!}
:: @parent @endsection
{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            {!! trans("admin/googlegroups.googlegroups") !!}
        </h3>
    </div>

    {!! Form::open(array('url' => url('admin/google-groups'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}

 <div class="form-group  {{ $errors->has('google_domain_id') ? 'has-error' : '' }}">
{!! Form::label('google_domain_id', "Google Domain", array('class' => 'control-label')) !!}
                <div class="controls">
                 <select style="width: 30%" name="google_domain_id" id="google_domain_id" class="form-control">
                    @foreach($googledomains as $domain)
                    <option value="{{$domain->id}}"
                            @if($selected_domain_id==$domain->id)
                                selected="selected"
                            @endif
                     >{{$domain->name}}</option>
                    @endforeach
                </select>
                </div>
                </div>

    {!! Form::close() !!}
 

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>{!! trans("admin/googlegroups.groupid") !!}</th>
            <th>{!! trans("admin/googlegroups.groupname") !!}</th>
            <th>{!! trans("admin/googlegroups.email") !!}</th>
            <th>{!! trans("admin/googlegroups.smart") !!}</th>

        </tr>
        </thead>
        <tbody>
		 @if(count($glist))
					@foreach ($glist as $group)
						<tr>
							<td>{!! $group['google_group_id'] !!}</td>
							<td>{!! $group['name'] !!}</td>
							<td>{!! $group['email'] !!}</td>
							<td>@if($group['smart']) <a href=/admin/smartgroup/{{$group['id']}}/edit>Edit Smart Group</a> @else <a href=/admin/smartgroup/create2/{{$group['google_group_id']}}>Make Smart</a> @endif </td>
						</tr>
				   @endforeach
				 @else
					    <tr>
							<td><p>No groups found</p></td>

						</tr>
				 @endif



		</tbody>
    </table>
@endsection

{{-- Scripts --}}
@section('scripts')

<script type="text/javascript">

$("#google_domain_id").on('change', function() {

var val = $(this).val();

$(location).attr('href', '/admin/google-groups/' + val);

});

</script>

@endsection
