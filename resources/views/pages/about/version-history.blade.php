@extends('layouts.master')

{{-- META TAGS 4 SEO --}}
@section('title')
	Whats New in Curriculum
@stop

@section('description')
@stop

{{-- WEBSITE CONTENT --}}
@section('content')
	<h2 class="type--header type--thin">Version History</h2>
	<h2>Curriculum 2.0.1 <small>Release Date: 02/27/18</small></h2>
	<p>
		<strong>Bug Fixes:</strong>
		<ol>
			<li>Restore the error message when a record is not found.</li>
		</ol>
		<strong>Improvements:</strong>
		<ol>
			<li>Upgrade the current code base to the latest version.</li>
		</ol>
	</p>
	<hr>
	<h2>Curriculum 2.0.0 <small>Release Date: 02/19/18</small></h2>
	<p>
		<strong>New Features:</strong>
	<ol>
		<li>Ability to retrieve all undergraduate plans.</li>
		<li>Ability to retrieve all graduate plans.</li>
		<li>Ability to retrieve information for a specific degree plan.</li>
	</ol>
	<strong>Improvements:</strong>
	<ol>
		<li>Class information now includes enrollment capacity and number of students currently enrolled.</li>
		<li>Class information now includes wait list capacity and number of students on wait list.</li>
	</ol>
	</p>
	<hr>
	<h2>Curriculum 1.0.0 <small>Release Date: 03/19/14</small></h2>
	<p>Initial Release</p>
@stop