@extends('layouts.master')

@section('title')

Modify User

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Modify User</h1>

		</div>

	</div>

	{!! Form::open(['method' => 'PUT', 'route' => ['admin.users.update', $user->id]]) !!}

	<div class="row">

		<div class="col-xs-6">

			<div class="form-group">

				<h3>Name</h3>
				<p class="form-control-static">
					{{ $user->individual->common_name }}
				</p>

			</div>

			<div class="form-group">

				<h3>Roles</h3>

				@foreach($roles as $role)

				<div class="checkbox">
				  <label>
				  	{!! Form::checkbox('roles[]', $role->system_name, $user->hasRole($role->system_name), []) !!}
				    {{ $role->display_name }}
				  </label>
				</div>

				@endforeach

			</div>

			<div class="form-group">

				<h3>Status</h3>

				<div class="checkbox">
				  <label>
				  	{!! Form::checkbox('active', true, $user->isActive(), []) !!}
				    Account is Active
				  </label>
				</div>

			</div>

		</div>

	</div>

	<div class="row">

		<div class="col-xs-6">

			{!! Form::submit('Update User', ['class'=>'btn btn-success'])!!}

		</div>

	</div>

	{!! Form::close() !!}

@stop