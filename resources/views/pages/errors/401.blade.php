@extends('layouts.master-basic')

@section('content')
	
	<!-- Page Main Content -->
	<div class="row">

		<h1>Unauthorized</h1>
		
	</div>
	
	<div class="row">

		@if (!empty($e))
		<p>{{{ $e->getMessage() }}}</p>
		@else
		<p>You are not allowed to access this content.</p>
		@endif
			
	</div>

@stop