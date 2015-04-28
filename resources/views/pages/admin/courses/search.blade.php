@extends('layouts.master')

@section('title')

Add User

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Search Courses</h1>

		</div>

	</div>

	{!! Form::open(['route' => 'admin.users.store']) !!}

	<div class="row">

		<div class="col-xs-6">

			<div class="form-group">

				{!! Form::label('search', 'Search for a course') !!}

				<div class="input-group">

					{!! Form::input('text', 'search', '', ['class' => 'form-control', 'aria-describedby'=>'help-search']) !!}

					<span class="input-group-btn">
			        	<button class="btn btn-primary" type="button" id="btn-search">
			        		<i class="glyphicon glyphicon-search"></i>
			        		Search
			        	</button>
			      	</span>

				</div>

				<span id="help-search" class="help-block">
					Search by catalog designation, subject, course number, or course title.
				</span>

			</div>

		</div>

	</div>

	{!! Form::close() !!}

	<div class="row">

		<div class="col-xs-12" id="search-results">

		</div>

	</div>

	<script type="text/javascript">

		/**
		 * Performs the search with the specified string query.
		 *
		 * @param string query The query to submit for searching
		 */
		function doSearch(query) {
			if(query == "") return;

			$("#search-results").empty();
			$("#search-results").append("<p>Searching. Please wait...");

			$.post("{{ url('admin/courses/search') }}", {'query' : $('#search').val() }, function(data) {
				$("#search-results").empty();

				// ensure there were records retrieved before proceeding
				if(data.length == 0) {
					$("#search-results").append("<p><strong>No results found for that query.</strong></p>");
				}
				else
				{
					// start the table
					$("#search-results").append(
						"<table class='table'><thead><tr><th>Subject</th><th>Catalog Number</th><th>Title</th><th>Actions</th></tr></thead><tbody>"
					);

					// iterate over the returned data and build the table
					$.each(data, function(key, result) {
						$("#search-results > table > tbody").append(
							"<tr><td>" + result.subject + "</td><td>" + result.catalog_number + "</td><td>" + result.title + "</td>" +
							"<td>" +
								@if(Auth::user()->hasPerm('course.modify'))
									"<a href='{{ url('/admin/courses/') }}/" + result.course_id + "/edit' class='btn btn-sm btn-warning'><i class='glyphicon glyphicon-pencil'></i> Modify</a>" +
								@endif
							"</td></tr>"
						);
					});

					// close the table
					$("#search-results > table").append(
						"</tbody></table>"
					);

				}

			}, 'json');
		}

		$(document).ready(function() {
			$("#btn-search").click(function(e) {
				e.preventDefault();
				doSearch($("#search").val());
			});

			$("form").submit(function() {
				return false;
			});

			if($("#search").val() != "") {
				// invoke the query directly if this is the result of
				// a redirect back to this point
				doSearch($("#search").val());
			}

		});

	</script>

@stop