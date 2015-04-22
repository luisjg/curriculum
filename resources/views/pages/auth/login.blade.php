@extends('layouts.master')
@section('content')

	<div class="row">
		<div class="col-xs-5">
			<h1>Login</h1>

			{!! Form::open() !!}
			<div class="form-group">
				{!! Form::label('username','Username') !!}
				{!! Form::input('text', 'username', '', ['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('password','Password') !!}
				{!! Form::input('password', 'password', '', ['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::submit('Login', ['class'=>'btn btn-primary']) !!}
			</div>
			{!! Form::close() !!}

			<p>CSUN Member: <a href="#">User ID</a> <a href="#">Password</a></p>
			<p>Off Campus/Guest: <a href="#">User ID</a> <a href="#">Password</a></p>
			<p>Need Help? <a href="#">Help</a> <a href="#">Getting Started</a></p>
		</div>
	</div>

@stop