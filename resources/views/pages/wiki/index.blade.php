@extends('layouts.master-wiki')


@section('sidebar')

	<ul class="nav">
		<li><a href="#introduction">Introduction</a></li>
		<li><a href="#howtouse">How to use</a></li>
		<li class="featured"><a href="#subcollection">Subcollection</a></li>
		<li class="featured"><a href="#instance">Instance</a></li>
		<li class="featured"><a href="#query">Query</a></li>
		<li><a href="#examples">Example</a></li>	
	</ul>

	
	<a href="{!! asset('pdfs/CurriculumWebService.pdf') !!}" class="download" target="_blank">
		<span class="glyphicons glyphicons-download-alt"></span>
		System Description
	</a>

@stop


@section('content')

	<div class="types" id="introduction">
		<h3>Introduction</h3>
		<p>
			The curriculum web service gives information about courses and classes.
			This information is derived from the CSUN catalog and SOLAR.
			The web service provides a gateway to access the information via a REST-ful API.
			The usage is composed by creating an URI giving values to filter the data. 
			The information that is returned is a JSON object that contains a set of courses or classes, 
			the format of the JSON object is as follows:
		</p>
		
		<pre class="prettyprint introduction">
{
	"status": 200,
	"success": true,
	"version": "omar­1.0",
	"type": "courses",
	"courses": [
		{
			"subject": "COMP",
			"catalog_number": "100",
			"title": "Computers: Their Impact and Use",
			"course_id": "19187",
			"description": "Not open to ...",
			"units" : "3",
			"term": "Fall­2014"
		},
		{
			"subject": "COMP",
			"catalog_number": "101",
			"title": "Introduction to Algorithms",
			"course_id": "19185",
			"description": "Not open to ...",
			"units": "2",
			"term": "Fall­2014"
		},
		...
	]
}
	</pre>
	</div>


	<div class="types instructions" id="howtouse">
		<h3>How to use</h3>

		<div class="list-box">
			<span class="list-type">1</span> <span class="title">Generate the URI</span>
			<p>Find the usage that fits your need, browse through subcolection, instace and query types to help you to craft it.</p>

			<span class="list-type">2</span> <span class="title">Provide the data</span>
			<p>Use the URI to query your data. See the Example session.</p>

			<span class="list-type">3</span> <span class="title">Show the results</span>
			<p>Loop through the data displaying their information. See the Example session.</p>
		</div>
	
	</div>

	<hr>

	<div class="types" id="subcollection">
		<h3>Subcollection</h3>
	
		<div class="well">
			<p>	The subcollection URI allows the consumer to obtain a list of courses or classes that are
			either part of a single program or Class Name.</p>
		</div>

		<h3 class="highlighted">Examples</h3>
		
		<h5>Course Classes By Subject</h5>
		<p class="urls">{!! link_to('api/classes/comp') !!}</p>
		<p class="urls">{!! link_to('api/classes/comp-110') !!}</p>
		<p class="urls">{!! link_to('api/terms/Fall-2014/classes/comp-110') !!}</p>
	</div>
	


	<div class="types" id="instance">
		<h3>Instance</h3>
		
		<div class="well">
			<p>	The instance URI allows the consumer to obtain information
			about a single course or a single class.</p>
		</div>

		<h3 class="highlighted">Examples</h3>

		<h5>Single Class</h5>
		<p class="urls">{!! link_to('api/classes/15223') !!}</p>

		<h5>Course Listings</h5>
		<p class="urls">{!! link_to('api/courses/comp') !!}</p>
		<p class="urls">{!! link_to('api/terms/Fall-2014/courses/comp') !!}</p>

	</div>


	<div class="types" id="query">
		<h3>Query</h3>
		
		<div class="well">
			<p>	The query URI allows a consumer to obtain a list of courses or classes that meet a
			particular criteria.</p>
		</div>

		<h3 class="highlighted">Examples</h3>

		<h5>Non-Current Term Classes</h5>
		<p class="urls">{!! link_to('api/terms/Fall-2013/classes/comp') !!}</p>
		<p class="urls">{!! link_to('api/terms/Spring-2013/classes/comp') !!}</p>
		<p class="urls">{!! link_to('api/terms/Fall-2014/classes/comp-322') !!}</p>
		<p class="urls">{!! link_to('api/terms/Fall-2014/classes?instructor=steven.fitzgerald@csun.edu') !!}</p>

		<h5>Course Classes Taught by Instructor</h5>
		<p class="urls">{!! link_to('api/classes?instructor=harry.hellenbrand@csun.edu') !!}</p>
	</div>


	<div id="examples" class="types">
	<h3>Usage Example</h3>

		<div role="tabpanel" class="tabpanel">
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#php" aria-controls="php" role="tab" data-toggle="tab">PHP</a></li>

		    <li role="presentation"><a href="#python" aria-controls="messages" role="tab" data-toggle="tab">Python</a></li>

		    <li role="presentation"><a href="#js" aria-controls="messages" role="tab" data-toggle="tab">JavaScript</a></li>
		 
		  </ul>

		  <!-- Tab panes -->
			<div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="php">
			    	<pre class="prettyprint">

// query all courses
$url = '{{ url('api/courses/comp') }}';

// call url, you can also use CURL or guzzle -> https://github.com/guzzle/guzzle
$data = file_get_contents($url);

// decode into an array
$data = json_decode($data, true);

// setup a blank array
$course_codes = [];

// loop through results and add to subject_numbers array
foreach($data['courses'] as $course){
	$course_codes[] = $course['subject'].' '.$course['catalog_number'];
}

print_r($course_codes);
					</pre>
				</div>


				<div role="tabpanel" class="tab-pane" id="python">	    	
			    	<pre class="prettyprint">

#python
import urllib2
import json

#query all courses
url = u'{{ url('api/courses/comp') }}'

#try to read the data	
try:
   u = urllib2.urlopen(url)
   data = u.read()
except Exception as e:
	data = {}

#decode into an array
data = json.loads(data)

#setup a blank array
course_codes = []

#loop through results and add to subject_numbers array
for course in data['courses']:
	course_codes.append(course['subject']+ ' ' + course['catalog_number'])

print course_codes
					</pre>
			    </div>


			    <div role="tabpanel" class="tab-pane" id="js">	    	
			    	<pre class="prettyprint">

// this example assumes jQuery integration for ease of use
// and a &lt;div&gt; element with the ID of "course-results"

var url = '{{ url('api/courses/comp') }}';
$(document).ready(function() {

	// perform a shorthand AJAX call to grab the information
	$.get(url, function(data) {

		// iterate over the returned courses
		var courses = data.courses;
		$(courses).each(function(index, course) {

			// append each course to the content of the element
			$('#course-results').append('&lt;p&gt;' + course.subject + ' ' + course.catalog_number + '&lt;/p&gt;');

		});
		
	});

});

					</pre>
			    </div>
			</div>
		</div>
	</div>

@stop

