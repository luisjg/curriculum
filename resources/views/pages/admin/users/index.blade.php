@extends('layouts.master')

@section('title')

Manage Users

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Manage Users</h1>
			
		</div>

	</div>

	@if(Auth::user()->hasPerm('user.create'))

	<div class="row">

		<div class="col-xs-12">

			<div class="pull-right">

				<a href="{{ route('admin.users.create') }}" class="btn btn-primary">

					<i class="glyphicon glyphicon-plus"></i>
					Add User

				</a>

			</div>

		</div>

	</div>

	@endif

	<div class="row">

		<div class="col-xs-12">

			@if($users->count() > 0)
			<div class="pull-left">

				{!! $users->render() !!}

			</div>
			@endif

		</div>

	</div>

	<div class="row">

		<div class="col-xs-12">

			<table class="table">

				<thead>

					<tr>

						<th>Name</th>
						<th>Active?</th>
						<th>Actions</th>

					</tr>

				</thead>

				<tbody>

					@forelse($users as $user)

					<tr>

						<td>{{ $user->individual->common_name }}</td>
						<td>
							@if($user->isActive())

								<span class="sr-only">Active</span>
								<i class="glyphicon glyphicon-ok"></i>

							@else

								<span class="sr-only">Inactive</span>

							@endif
						</td>
						<td>
							@if(Auth::user()->hasPerm('user.modify') && $user->individuals_id != Auth::user()->individuals_id)
								<a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" title="Modify user {{ $user->individual->common_name }}" class="btn btn-sm btn-warning">
									<i class="glyphicon glyphicon-pencil"></i>
									Modify
								</a>
							@endif
						</td>

					</tr>

					@empty

					<tr>
						<td colspan="4">
							There are currently no users assigned to the system.
						</td>
					</tr>

					@endforelse

				</tbody>

			</table>

		</div>

	</div>

@stop