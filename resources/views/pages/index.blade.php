{{--
  Curriculum Web Service - Backend that delivers CSUN class and course information.
  Copyright (C) 2014-2019 - CSUN META+LAB

  Waldo Web Service is free software: you can redistribute it and/or modify it under the terms
  of the GNU General Public License as published by the Free Software Found
  ation, either version 3 of the License, or (at your option) any later version.

  RetroArch is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
  PURPOSE.  See the GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along with RetroArch.
  If not, see <http://www.gnu.org/licenses/>.
 --}}
@extends('layouts.master')
@section('title')
	Documentation
@endsection
@section('content')
	<h3 class="type--header type--thin" id="introduction">Introduction</h3>
	<p>
		The {{ env('APP_NAME') }} web service gives information about courses and classes.
		This information is derived from the CSUN catalog and SOLAR.
		The web service provides a gateway to access the information via a REST-ful API.
		The information is retrieved by creating a specific URI and giving values to filter the data. 
		The information that is returned is a JSON object that contains a set of courses or classes; 
		the format of the JSON object is as follows:
	</p>
	<pre class="prettyprint"><code>
{
  "api": "curriculum",
  "status": "200",
  "success": "true",
  "version": "2.0",
  "collection": "courses",
  "courses": [
    {
      "subject": "COMP",
      "catalog_number": "100",
      "section_number": "06",
      "title": "Computers: Their Impact and Use",
      "course_id": 10080,
      "description": "Not open to Computer Science majors. Introduction to the uses concepts techniques and terminology of computing. Places the possibilities and problems of computer use in historical economic and social contexts. Shows how computers can assist in a wide range of personal commercial and organizational activities. Typical computer applications including word processing spreadsheets and databases. (Available for General Education Lifelong Learning.) (IC)\n",
      "units": "3",
      "term": "Spring-2018"
    },
    {
      "subject": "COMP",
      "catalog_number": "100HON",
      "section_number": "01",
      "title": "COMPTRS/IMPCT-USE",
      "course_id": 21107,
      "description": null,
      "units": "3",
      "term": "Spring-2018"
    },
   ...
   ]
}
	</code></pre>

	<h3 class="type--header type--thin" id="howtouse">How to use</h3>
	<ol>
		<li><strong>Generate the URI</strong><br>
		Find the usage that fits your need. Browse through subcollections, instances and query types to help you craft your URI.</lo>

		<li><strong>Provide the data</strong><br>
		Use the URI to query your data. See the Usage Example session.</li>

		<li><strong>Show the results</strong><br>
		Loop through the data to display its information. See the Usage Example session.</li>
	</ol>
	<h3 class="type--header type--thin" id="subcollection">Collection</h3>
	<div class="panel">
		<div class="panel__content">
		The collection URI allows the consumer to obtain a list of degree plans.
		</div>
	</div>
	<h3 class="type--thin">Examples</h3>
	<strong>Degree Plans</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/plans') !!}">{!! url('api/2.0/plans') !!}</a></li>
	</ul>
	<h3 class="type--header type--thin" id="subcollection">Subcollection</h3>
	<div class="panel">
		<div class="panel__content">
		The subcollection URI allows the consumer to obtain a list of courses, classes, or degree plans that are
		either part of a single program, a class name, or a set of degree plans.
		</div>
	</div>
	<h3 class="type--thin">Examples</h3>
	<strong>Course Classes By Subject</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/classes/comp') !!}">{!! url('api/2.0/classes/comp') !!}</a></li>
		<li class="list__item"><a href="{!! url('api/2.0/classes/comp-110') !!}">{!! url('api/2.0/classes/comp-110') !!}</a></li>
		<li class="list__item"><a href="{!! url('api/2.0/terms/Spring-2015/classes/comp-110') !!}">{!! url('api/2.0/terms/Spring-2015/classes/comp-110') !!}</a></li>
		<li class="list__item"><a href="{!! url('api/2.0/terms/2153/classes/comp-110') !!}">{!! url('api/2.0/terms/2153/classes/comp-110') !!}</a></li>
	</ul>
	<strong>Course Listings</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/courses/comp') !!}">{!! url('api/2.0/courses/comp') !!}</a></li>
		<li class="list__item"><a href="{!! url('api/2.0/terms/Spring-2015/courses/comp') !!}">{!! url('api/2.0/terms/Spring-2015/courses/comp') !!}</a></li>
		<li class="list__item"><a href="{!! url('api/2.0/terms/2153/courses/comp') !!}">{!! url('api/2.0/terms/2153/courses/comp') !!}</a></li>
	</ul>
	<strong>Degree Plan Listings</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/plans/graduate') !!}">{!! url('api/2.0/plans/graduate') !!}</a></li>
		<li class="list__item"><a href="{!! url('api/2.0/plans/undergraduate') !!}">{!! url('api/2.0/plans/undergraduate') !!}</a></li>
	</ul>
	
	<h3 class="type--header type--thin" id="instance">Instance</h3>	
	<div class="panel">
		<div class="panel__content">
			The instance URI allows the consumer to obtain information
			about a single course, class, or degree plan.
		</div>
	</div>
	<h3 class="type--thin">Examples</h3>
	<strong>Single Class</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/classes/15223') !!}">{!! url('api/2.0/classes/15223') !!}</a></li>
	</ul>
	<strong>Single Course</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/courses/comp-100') !!}">{!! url('api/2.0/courses/comp-100') !!}</a></li>
	</ul>
	<strong>Single Degree Plan</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/plans/561208B') !!}">{!! url('api/2.0/plans/561208B') !!}</a> (Computer Science - Undergraduate Degree)</li>
		<li class="list__item"><a href="{!! url('api/2.0/plans/561208A') !!}">{!! url('api/2.0/plans/561208A') !!}</a> (STAR Computer Science - Undergraduate Degree)</li>
		<li class="list__item"><a href="{!! url('api/2.0/plans/450503V') !!}">{!! url('api/2.0/plans/450503V') !!}</a> (Deaf Studies - Undergraduate Degree)</li>
		<li class="list__item"><a href="{!! url('api/2.0/plans/897665Y') !!}">{!! url('api/2.0/plans/897665Y') !!}</a> (Public Sector Management - FTF - Undergraduate Degree)</li>
		<li class="list__item"><a href="{!! url('api/2.0/plans/561208R') !!}">{!! url('api/2.0/plans/561208R') !!}</a> (Computer Science - Undergraduate Minor)</li>
		<li class="list__item"><a href="{!! url('api/2.0/plans/561208M') !!}">{!! url('api/2.0/plans/561208M') !!}</a> (Computer Science - Graduate Degree)</li>
		<li class="list__item"><a href="{!! url('api/2.0/plans/561208T') !!}">{!! url('api/2.0/plans/561208T') !!}</a> (Computer Science - Graduate Degree)</li>
		<li class="list__item"><a href="{!! url('api/2.0/plans/785845S') !!}">{!! url('api/2.0/plans/785845S') !!}</a> (Mathematics - Graduate Minor)</li>
	</ul>

	<h3 class="type--header type--thin" id="query">Query</h3>
	<div class="panel">
		<div class="panel__content">
		The query URI allows a consumer to obtain a list of courses or classes that meet a
		particular criteria.	
		</div>
	</div>
	<h3 class="type--thin">Examples</h3>
	<strong>Non-Current Term Classes</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/terms/Spring-2015/classes/comp') !!}">{!! url('api/2.0/terms/Spring-2015/classes/comp') !!}</a></li>
		<li class="list__item"><a href="{!! url('api/2.0/terms/Spring-2015/classes/comp-322') !!}">{!! url('api/2.0/terms/Spring-2015/classes/comp-322') !!}</a></li>
		<li class="list__item"><a href="{!! url('api/2.0/terms/Spring-2015/classes?instructor=steven.fitzgerald@csun.edu') !!}">{!! url('api/2.0/terms/Spring-2015/classes?instructor=steven.fitzgerald@csun.edu') !!}</a>
		</li>
		<li class="list__item"><a href="{!! url('api/2.0/terms/2153/classes?instructor=steven.fitzgerald@csun.edu') !!}">{!! url('api/2.0/terms/2153/classes?instructor=steven.fitzgerald@csun.edu') !!}</a></li>
	</ul>
	<strong>Course Classes Taught by Instructor</strong>
	<ul class="list--unstyled">
		<li class="list__item"><a href="{!! url('api/2.0/classes?instructor=steven.fitzgerald@csun.edu') !!}">{!! url('api/2.0/classes?instructor=steven.fitzgerald@csun.edu') !!}</a></li>
	</ul>

	<h3 class="type--header type--thin" id="examples">Usage Example</h3>
	<dl class="accordion">
		<dt class="accordion__header"> JavaScript <i class="fa fa-chevron-down fa-pull-right type--red" aria-hidden="true"></i></dt>
		<dd class="accordion__content">
	    	<pre>
	    	<code class="prettyprint lang-javascript">


// this example assumes jQuery integration for ease of use
// and a &lt;div&gt; element with the ID of "course-results"

// query all CompSci courses
var url = '{!! url('api/2.0/courses/comp') !!}';
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
			</code>
			</pre>
		</dd>
		<dt class="accordion__header"> PHP <i class="fa fa-chevron-down fa-pull-right type--red" aria-hidden="true"></i></dt>
		<dd class="accordion__content">
    	<pre>
    	<code class="prettyprint lang-php">
// query all CompSci courses
$url = '{!! url('api/2.0/courses/comp') !!}';

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
			</code>
			</pre>
		</dd>
		<dt class="accordion__header"> Python <i class="fa fa-chevron-down fa-pull-right type--red" aria-hidden="true"></i></dt>
		<dd class="accordion__content">
	    	<pre>
	    	<code class="prettyprint lang-python">
#python
import urllib2
import json

#query all CompSci courses
url = u'{!! url('api/2.0/courses/comp') !!}'

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
			</code>
			</pre>
		</dd>
		<dt class="accordion__header"> Ruby <i class="fa fa-chevron-down fa-pull-right type--red" aria-hidden="true"></i></dt>
		<dd class="accordion__content">
	    	<pre>
	    	<code class="prettyprint lang-ruby">
require 'net/http'
require 'json'

#query all CompSci courses
source = '{!! url('api/2.0/courses/comp') !!}'

#call data
response = Net::HTTP.get_response(URI.parse(source))

#get body of the response
data = response.body

#put the parsed data
puts JSON.parse(data)
			</code>
	    	</pre>
		</dd>
	</dl>
@endsection

