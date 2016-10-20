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
@endsection
