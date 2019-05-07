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

{{-- META TAGS 4 SEO --}}
@section('title')
	Version History
@endsection

{{-- WEBSITE CONTENT --}}
@section('content')
	<h2 class="type--header type--thin">Version History</h2>
	<h2>{{ env('APP_NAME') }} 2.0.1 <small>Release Date: 02/27/18</small></h2>
	<p>
		<strong>Bug Fixes:</strong>
		<ol>
			<li>Restore the error message when a record is not found.</li>
		</ol>
		<strong>Improvements:</strong>
		<ol>
			<li>Upgrade the current code base to the latest version.</li>
		</ol>
	</p>
	<hr>
	<h2>{{ env('APP_NAME') }} 2.0.0 <small>Release Date: 02/19/18</small></h2>
	<p>
		<strong>New Features:</strong>
	<ol>
		<li>Ability to retrieve all undergraduate plans.</li>
		<li>Ability to retrieve all graduate plans.</li>
		<li>Ability to retrieve information for a specific degree plan.</li>
	</ol>
	<strong>Improvements:</strong>
	<ol>
		<li>Class information now includes enrollment capacity and number of students currently enrolled.</li>
		<li>Class information now includes wait list capacity and number of students on wait list.</li>
	</ol>
	</p>
	<hr>
	<h2>{{ env('APP_NAME') }} 1.0.0 <small>Release Date: 03/19/14</small></h2>
	<p>Initial Release</p>
@endsection