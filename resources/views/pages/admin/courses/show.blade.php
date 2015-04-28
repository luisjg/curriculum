@extends('layouts.master')

@section('title')

Course Detail

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Course Detail</h1>

		</div>

	</div>

	@if(Auth::user()->hasPerm('course.modify'))

	<div class="row">

		<div class="col-xs-12">

			<div class="pull-right">

				<a href="{{ route('admin.courses.edit', ['id' => $course->course_id]) }}" class="btn btn-warning">
					<i class="glyphicon glyphicon-pencil"></i>
					Modify Course
				</a>

			</div>
		
		</div>

	</div>

	@endif

	<div class="row">

		<div class="col-xs-6">

			<h4>Course ID</h4>

			<p>{{ $course->course_id }}</p>
			<p>&nbsp;</p>

			<h4>Title</h4>

			<p>{{ $course->title }}</p>
			<p>&nbsp;</p>

			<h4>Catalog Designation</h4>

			<p>{{ $course->subject }} {{ $course->catalog_number }}</p>

		</div>

	</div>

@stop