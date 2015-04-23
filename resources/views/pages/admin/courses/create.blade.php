@extends('layouts.master')
@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Create Course</h1>

		</div>

	</div>

	{!! Form::open(['route' => 'admin.courses.store']) !!}

	<div class="row">

		<div class="col-xs-6">

			<div class="form-group">

				{!! Form::label('course_id','Course ID') !!}
				{!! Form::input('text', 'course_id', '', ['class'=>'form-control', 'aria-describedby'=>'help-course-id']) !!}

				<span id="help-course-id" class="help-block">
					Example: for <em>ENGL 255</em> the course ID would be 2722.
				</span>

			</div>

			<div class="form-group">

				{!! Form::label('title','Title') !!}
				{!! Form::input('text', 'title', '', ['class'=>'form-control', 'aria-describedby'=>'help-title']) !!}

				<span id="help-title" class="help-block">
					Example: for <em>ENGL 255</em> the title would be INTRO TO LIT.
				</span>

			</div>

			<div class="form-group">

				{!! Form::label('subject', 'Subject') !!} <br/>
				{!! Form::select('subject', array_merge([""=>""], $subjects), 'Select a Subject', ['class' => 'form-control', 'aria-describedby'=>'help-subject']) !!}

				<span id="help-subject" class="help-block">
					Example: for <em>ENGL 255</em> the subject would be ENGL.
				</span>

			</div>

			<div class="form-group">

				{!! Form::label('catalog_number','Catalog Number') !!}
				{!! Form::input('text', 'catalog_number', '', ['class'=>'form-control', 'aria-describedby'=>'help-catalog-number']) !!}

				<span id="help-catalog-number" class="help-block">
					Example: for <em>ENGL 255</em> the catalog number would be 255.
				</span>

			</div>

		</div>

	</div>

	<div class="row">

		<div class="col-xs-6">

			{!! Form::submit('Create Course', ['class'=>'btn btn-success'])!!}

		</div>

	</div>

	{!! Form::close() !!}

@stop