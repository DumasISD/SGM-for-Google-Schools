@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/googleusers.googleusers") !!}
:: @parent @endsection
{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            {!! trans("admin/googleusers.googleusers") !!}
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
            <th>Id</th>
            <th>{!! trans("admin/googleusers.name") !!}</th>
            <th>{!! trans("admin/googleusers.email") !!}</th>

        </tr>
        </thead>
        <tbody>
		<?php

		?>
		 @if(count($users_list))
					@foreach ($users_list->getUsers() as $user)
						<tr>
							<td>{!! $user->getId() !!}</td>

							<td>{!! $user->getName()->getFullName() !!}</td>
							<td>{!! $user->getPrimaryEmail() !!}</td>
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

$(location).attr('href', '/admin/google-users/' + val);

});

</script>

@

@endsection
