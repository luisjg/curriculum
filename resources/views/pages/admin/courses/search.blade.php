@extends('layouts.master')

@section('title')

Add User

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Search Courses</h1>

		</div>

	</div>

	{!! Form::open(['route' => 'admin.users.store']) !!}

	<div class="row">

		<div class="col-xs-6">

			<div class="form-group">

				{!! Form::label('search', 'Search for a course') !!}

				<div class="input-group">

					{!! Form::input('text', 'search', '', ['class' => 'form-control', 'aria-describedby'=>'help-search']) !!}

					<span class="input-group-btn">
			        	<button class="btn btn-primary" type="button" id="btn-search">
			        		<i class="glyphicon glyphicon-search"></i>
			        		Search
			        	</button>
			      	</span>

				</div>

				<span id="help-search" class="help-block">
					Search by catalog designation or course title.
				</span>

			</div>

		</div>

	</div>

	<div class="row">

		<div class="col-xs-12" id="search-results">

		</div>

	</div>

@stop