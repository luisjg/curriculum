<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Curriculum Web Service | @yield('title', 'Admin')</title>

	<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/util.css') }}" rel="stylesheet" />

	<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
<body>

	@include('layouts.partials.header')

	<div class="container">

		@if ($errors->count() > 0)
			<div class="row">
				<div class="alert alert-danger alert-dismissible" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  					<span aria-hidden="true">&times;</span>
	  				</button>
					<p>The following errors occurred:</p>
					<p>&nbsp;</p>
					<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
			</div>
		@elseif (!empty($success) || Session::has('success'))
			<div class="row">
				<div class="alert alert-success alert-dismissible" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  					<span aria-hidden="true">&times;</span>
	  				</button>
	  				<p>
	  					@if (Session::has('success'))
	  						{{ session('success') }}
	  					@else
	  						{{ $success }}
	  					@endif
	  				</p>
	  			</div>
			</div>
		@endif

		@yield('content')
		
	</div>

</body>
</html>