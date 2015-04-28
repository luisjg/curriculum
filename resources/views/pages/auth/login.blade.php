@extends('layouts.master')

@section('title')

Login

@stop

@section('content')

	<div class="row">
		<p>&nbsp;</p>
	</div>

	<div class="row">
		<div class="col-xs-offset-3 col-xs-6">
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title text-center">Please Login to Continue</h3>
			  </div>
			  <div class="panel-body">
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
			  </div>
			</div>
		</div>
	</div>

@stop