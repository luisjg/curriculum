@extends('layouts.master')
@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Manage Courses</h1>
			
		</div>

	</div>

	@if($courses->count() > 0)
	<div class="row">

		<div class="col-xs-12">

			{!! $courses->render() !!}

		</div>

	</div>
	@endif

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
						<td>{{ $course->title }}</td>
						<td>
							Actions
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