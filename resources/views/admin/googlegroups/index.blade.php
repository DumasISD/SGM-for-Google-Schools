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

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>{!! trans("admin/googlegroups.groupid") !!}</th>
            <th>{!! trans("admin/googlegroups.groupname") !!}</th>

        </tr>
        </thead>
        <tbody>
		 @if(count($group_list))
					@foreach ($group_list as $group)
						<tr>
							<td>{!! $group->getId() !!}</td>
							<td>{!! $group->getName() !!}</td>
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
