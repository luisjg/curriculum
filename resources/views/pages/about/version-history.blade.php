@extends('layouts.master')

{{-- META TAGS 4 SEO --}}
@section('title')
	Whats New in Curriculum  App
@stop

@section('description')
@stop

{{-- WEBSITE CONTENT --}}
@section('content')
	<h2 id="version-history" class="type--header type--thin">Version History</h2>
	<h2>Curriculum 1.0 <small>Release Date: 02/01/17</small></h2>
	<p>
		<strong>Improvements:</strong>
		<ol>
			<li>Include a version history section</li>
			<li>Upgrade to Lumen 5.5</li>
		</ol>
		<strong>Bug Fixes</strong>
		<ol>
			<li>Fix missing values on the example URLs</li>
		</ol>
	</p>
	<hr>
@stop