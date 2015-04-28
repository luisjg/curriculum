@extends('layouts.master')

@section('title')

Manage Courses

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Manage Courses</h1>
			
		</div>

	</div>

	<div class="row">

		<div class="col-xs-12">

			@if($courses->count() > 0)
			<div class="pull-left">

				{!! $courses->render() !!}

			</div>
			@endif

			@if(Auth::user()->hasPerm('course.create'))
			<div class="pull-right">

				<a href="{{ route('admin.courses.create') }}" class="btn btn-primary push-down">
					<i class="glyphicon glyphicon-plus"></i>
					Create New Course
				</a>

			</div>
			@endif

		</div>

	</div>

	<div class="row">

		<div class="col-xs-12">

			<table class="table">

				<thead>

					<tr>

						<th>Subject</th>
						<th>Catalog #</th>
						<th>Title</th>
						<th>Actions</th>

					</tr>

				</thead>

				<tbody>

					@forelse($courses as $course)

					<tr>

						<td>{{ $course->subject }}</td>
						<td>{{ $course->catalog_number }}</td>
						<td>
							<a href="{{ route('admin.courses.show', ['id' => $course->course_id]) }}">
								{{ $course->title }}
							</a>
						</td>
						<td>
							@if(Auth::user()->hasPerm('course.modify'))
								<a href="{{ route('admin.courses.edit', ['id' => $course->course_id]) }}" title="Modify course {{ $course->subject }} {{ $course->catalog_number }}" class="btn btn-sm btn-warning">
									<i class="glyphicon glyphicon-pencil"></i>
									Modify
								</a>
							@endif
						</td>

					</tr>

					@empty

					<tr>
						<td colspan="4">
							There are currently no courses available in the system.
						</td>
					</tr>

					@endforelse

				</tbody>

			</table>

		</div>

	</div>

@stop