@extends('layouts.master')

@section('title')

Add User

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12">

			<h1>Add User</h1>

		</div>

	</div>

	{!! Form::open(['route' => 'admin.users.store']) !!}

	<div class="row">

		<div class="col-xs-6">

			<div class="form-group">

				{!! Form::label('search', 'Search for an existing person') !!}

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
					Search by first name, last name, common name, or email address.
				</span>

			</div>

		</div>

	</div>

	<div class="row">

		<div class="col-xs-12" id="search-results">

		</div>

	</div>

	<div class="row hide" id="row-add-users">

		<div class="col-xs-6">

			{!! Form::submit('Add Selected Users', ['class'=>'btn btn-success']) !!}

		</div>

	</div>

	{!! Form::close() !!}

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

			$.post("{{ url('admin/users/search') }}", {'query' : $('#search').val() }, function(data) {
				$("#search-results").empty();

				// ensure there were records retrieved before proceeding
				if(data.length == 0) {
					$("#search-results").append("<p><strong>No results found for that query.</strong></p>");
				}
				else
				{
					// start the table
					$("#search-results").append(
						"<table class='table'><thead><tr><th>Last Name</th><th>First Name</th><th>Email</th><th>Select</th></tr></thead><tbody>"
					);

					// iterate over the returned data and build the table
					$.each(data, function(key, result) {
						if(result.common_name) {
							$("#search-results > table > tbody").append(
								"<tr><td>" + result.last_name + "</td><td>" + result.first_name + "</td><td>" + result.email + "</td>" +
								"<td>" +
									"<input type='checkbox' name='person[]' id='individual_" + result.individuals_id + "' value='" + result.individuals_id + "' />" +
									"<label class='sr-only' for='individual_" + result.individuals_id + "'>" +
										result.common_name
									+ "</label>" +
								"</td></tr>"
							);
						}
					});

					// close the table
					$("#search-results > table").append(
						"</tbody></table>"
					);

					// show the button to add the selected users if any
					$("#row-add-users").removeClass('hide');
				}

			}, 'json');
		}

		$(document).ready(function() {
			$("#btn-search").click(function(e) {
				e.preventDefault();
				$('#row-add-users').addClass('hide');
				doSearch($("#search").val());
			});

			$("form").submit(function() {
				// cancel the submission of the form if the submit row is hidden
				if($("#row-add-users").hasClass('hide')) return false;
			});

			if($("#search").val() != "") {
				// invoke the query directly if this is the result of
				// a redirect back to this point
				doSearch($("#search").val());
			}

		});

	</script>

@stop