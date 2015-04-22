@extends('layouts.master')
@section('content')
	<div class="welcome">
		<h1>Curriculum Web Service (OMAR)</h1>
		<a target="_blank" href="pdfs/CurriculumWebService.pdf">CurriculumWebService.pdf</a>

		<h2>Examples</h2>
		<dl>
			<dt>Course Classes By Subject</dt>
			<dd>{!! link_to('api/classes/comp') !!}</dd>
			<dd>{!! link_to('api/classes/comp-110') !!}</dd>
			<dd>{!! link_to('api/terms/Fall-2014/classes/comp-110') !!}</dd>

			<dt>Course Classes Taught by Instructor</dt>
			<dd>{!! link_to('api/classes?instructor=harry.hellenbrand@csun.edu') !!}</dd>

			<dt>Single Class</dt>
			<dd>{!! link_to('api/classes/15223') !!}</dd>

			<dt>Course Listings</dt>
			<dd>{!! link_to('api/courses/comp') !!}</dd>
			<dd>{!! link_to('api/terms/Fall-2014/courses/comp') !!}</dd>


			<dt>Non-Current Term Classes</dt>
			<dd>{!! link_to('api/terms/Fall-2013/classes/comp') !!}</dd>
			<dd>{!! link_to('api/terms/Spring-2013/classes/comp') !!}</dd>
			<dd>{!! link_to('api/terms/Fall-2014/classes/comp-322') !!}</dd>
			<dd>{!! link_to('api/terms/Fall-2014/classes?instructor=steven.fitzgerald@csun.edu') !!}</dd>
		</dl>

	</div>
@stop
