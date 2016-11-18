@extends('layouts.master-metaphor')
@section('content')
	<div class="types" id="introduction">
		<h3 class="type--header type--thin">Introduction</h3>
		<p>
			The curriculum web service gives information about courses and classes.
			This information is derived from the CSUN catalog and SOLAR.
			The web service provides a gateway to access the information via a REST-ful API.
			The information is retrieved by creating a specific URI and giving values to filter the data. 
			The information that is returned is a JSON object that contains a set of courses or classes; 
			the format of the JSON object is as follows:
		</p>
		<pre><code>
{
	"status": "200",
	"success": "true",
	"version": "curriculum-2.0",
	"type": "courses",
	"courses": [
		{
			"subject": "COMP",
			"catalog_number": "100",
			"title": "COMPTRS/IMPCT-USE",
			"course_id": "10080",
			"description": "Not open to ...",
			"units" : "3",
			"term": "Spring-2015"
		},
		{
			"subject": "COMP",
			"catalog_number": "110",
			"title": "INTRO ALGRTH/PROG",
			"course_id": "18237",
			"description": "Not open to ...",
			"units": "2",
			"term": "Spring-2015"
		},
		...
	]
}
	</code></pre>
	</div>
	<div class="types instructions" id="howtouse">
		<h3 class="type--header type--thin">How to use</h3>
		<ol>
			<li><strong>Generate the URI</strong><br>
			Find the usage that fits your need. Browse through subcollections, instances and query types to help you craft your URI.</lo>

			<li><strong>Provide the data</strong><br>
			Use the URI to query your data. See the Usage Example session.</li>

			<li><strong>Show the results</strong><br>
			Loop through the data to display its information. See the Usage Example session.</li>
		</ol>
	</div>
	<hr>
	<div class="types" id="subcollection">
		<h3 class="type--header type--thin">Subcollection</h3>
		<div class="panel">
			<div class="panel__content">
			The subcollection URI allows the consumer to obtain a list of courses or classes that are
			either part of a single program or Class Name.
			</div>
		</div>
		<h3 class="type--thin">Examples</h3>
		<strong>Course Classes By Subject</strong>
		<ul class="list">
			<li class="list__item">{!! link_to('api/classes/comp', null, ['target' => '_blank']) !!}</li>
			<li class="list__item">{!! link_to('api/classes/comp-110', null, ['target' => '_blank']) !!}</li>
			<li class="list__item">{!! link_to('api/terms/Spring-2015/classes/comp-110', null, ['target' => '_blank']) !!}</li>
			<li class="list__item">{!! link_to('api/terms/2153/classes/comp-110', null, ['target' => '_blank']) !!}</li>
		</ul>
		<strong>Course Listings</strong>
		<ul class="list">
			<li class="list__item">{!! link_to('api/courses/comp', null, ['target' => '_blank']) !!}</li>
			<li class="list__item">{!! link_to('api/terms/Spring-2015/courses/comp', null, ['target' => '_blank']) !!}</li>
			<li class="list__item">{!! link_to('api/terms/2153/courses/comp', null, ['target' => '_blank']) !!}</li>
		</ul>
	</div>
	
	<div class="types" id="instance">
		<h3 class="type--header type--thin">Instance</h3>	
		<div class="panel">
			<div class="panel__content">
				The instance URI allows the consumer to obtain information
				about a single course or a single class.
			</div>
		</div>
		<h3 class="type--thin">Examples</h3>
		<strong>Single Class</strong>
		<ul class="list">
			<li class="list__item">{!! link_to('api/classes/15223', null, ['target' => '_blank']) !!}</li>
		</ul>
		<strong>Single Course</strong>
		<ul class="list">
			<li class="list__item">{!! link_to('api/courses/comp-100', null, ['target' => '_blank']) !!}</li>
		</ul>
	</div>

	<div class="types" id="query">
		<h3 class="type--header type--thin">Query</h3>
		<div class="panel">
			<div class="panel__content">
			The query URI allows a consumer to obtain a list of courses or classes that meet a
			particular criteria.	
			</div>
		</div>
		<h3 class="type--thin">Examples</h3>
		<strong>Non-Current Term Classes</strong>
		<ul class="list">
			<li class="list__item">{!! link_to('api/terms/Spring-2015/classes/comp', null, ['target' => '_blank']) !!}</li>
			<li class="list__item">{!! link_to('api/terms/Spring-2015/classes/comp-322', null, ['target' => '_blank']) !!}</li>
			<li class="list__item">{!! link_to('api/terms/Spring-2015/classes?instructor=steven.fitzgerald@csun.edu', null, ['target' => '_blank']) !!}	</li>
			<li class="list__item">{!! link_to('api/terms/2153/classes?instructor=steven.fitzgerald@csun.edu', null, ['target' => '_blank']) !!}</li>
		</ul>
		<strong>Course Classes Taught by Instructor</strong>
		<ul class="list">
			<li class="list__item">{!! link_to('api/classes?instructor=steven.fitzgerald@csun.edu', null, ['target' => '_blank']) !!}</li>
		</ul>
	</div>

	<div id="examples" class="types">
	<h3 class="type--header type--thin">Usage Example</h3>
		<div role="tabpanel" class="tabpanel">
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#php" aria-controls="php" role="tab" data-toggle="tab">PHP</a></li>
		    <li role="presentation"><a href="#python" aria-controls="python" role="tab" data-toggle="tab">Python</a></li>
		    <li role="presentation"><a href="#ruby" aria-controls="ruby" role="tab" data-toggle="tab">Ruby</a></li>
		    <li role="presentation"><a href="#js" aria-controls="js" role="tab" data-toggle="tab">JavaScript</a></li>
		  </ul>
		  <!-- Tab panes -->
			<div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="php">
			    	<pre class="prettyprint">
// query all CompSci courses
$url = '{!! url('api/courses/comp') !!}';

// call url, you can also use CURL or guzzle -> https://github.com/guzzle/guzzle
$data = file_get_contents($url);

// decode into an array
$data = json_decode($data, true);

// setup a blank array
$course_list = [];

// loop through results and add each courses's subject
// and catalog number to course_list array (i.e. COMP 100)
foreach($data['courses'] as $course){
	$course_list[] = $course['subject'].' '.$course['catalog_number'];
}

print_r($course_list);
					</pre>
				</div>
				<div role="tabpanel" class="tab-pane" id="python">	    	
			    	<pre class="prettyprint">
#python
import urllib2
import json

#query all CompSci courses
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
course_list = []

#loop through results and add each course's subject
#and catalog number to course_list array (i.e COMP 100)
for course in data['courses']:
	course_list.append(course['subject'] + ' ' + course['catalog_number'])

print course_list
					</pre>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="ruby">
			    	<pre class="prettyprint">
require 'net/http'
require 'json'

#query all CompSci courses
source = '{{ url('api/courses/comp') }}'

#call data
response = Net::HTTP.get_response(URI.parse(source))

#get body of the response
data = response.body

#put the parsed data
puts JSON.parse(data)

			    	</pre>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="js">	    	
			    	<pre class="prettyprint">
// this example assumes jQuery integration for ease of use
// and a &lt;div&gt; element with the ID of "course-results"

// query all CompSci courses
var url = '{!! url('api/courses/comp') !!}';
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

