@extends('layouts.master')

@section('title')

Modify Course

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Modify Course</h1>

		</div>

	</div>

	{!! Form::open(['method' => 'PUT', 'route' => ['admin.courses.update', $course->course_id]]) !!}

	<div class="row">

		<div class="col-xs-6">

			<div class="form-group">

				{!! Form::label('title','Title') !!}
				{!! Form::input('text', 'title', $course->title, ['class'=>'form-control', 'aria-describedby'=>'help-title']) !!}

				<span id="help-title" class="help-block">
					Example: for <em>ENGL 255</em> the title would be INTRO TO LIT.
				</span>

			</div>

			<div class="form-group">

				{!! Form::label('subject', 'Subject') !!} <br/>
				{!! Form::select('subject', array_merge([""=>""], $subjects), $course->subject, ['class' => 'form-control', 'aria-describedby'=>'help-subject']) !!}

				<span id="help-subject" class="help-block">
					Example: for <em>ENGL 255</em> the subject would be ENGL.
				</span>

			</div>

			<div class="form-group">

				{!! Form::label('catalog_number','Catalog Number') !!}
				{!! Form::input('text', 'catalog_number', $course->catalog_number, ['class'=>'form-control', 'aria-describedby'=>'help-catalog-number']) !!}

				<span id="help-catalog-number" class="help-block">
					Example: for <em>ENGL 255</em> the catalog number would be 255.
				</span>

			</div>

		</div>

	</div>

	<div class="row">

		<div class="col-xs-6">

			{!! Form::submit('Update Course', ['class'=>'btn btn-success'])!!}

		</div>

	</div>

	{!! Form::close() !!}

@stop