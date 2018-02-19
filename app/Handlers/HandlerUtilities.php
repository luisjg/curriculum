<?php namespace Curriculum\Handlers;

use Curriculum\Models\ClassMembershipRoster;
use Request;
use Curriculum\Models\LoggedRequest,
	Curriculum\Models\Term;

class HandlerUtilities
{
	/* Place all helper methods here */


	/**
	 * Retrieves the Term Code for the current Semester
	 * @todo Throw an Exception when current term doesn't exist
	 * @return Current Term Code (e.g 2147)
	 *
	 */
	public static function getCurrentTermID(){
	        $current_date = date("Y-m-d H:i:s");

	        /* Get First term that that falls between these days */
	        /* Note: muliple semesters avaiable at the same time during the summer and GRAD/UGRD */
	        $term = Term::where('begin_date', '<=', $current_date)
	                    ->where('end_date', '>', $current_date)
	                    ->first(); 

	        /* In between semesters, just use the last semester as default */
	        if (!$term) {
	            $term = Term::where('end_date', '<', $current_date)->orderBy('end_date', 'desc')->first();
	        }

	        /* Return current semester's term_id or 0 if no matches */

	        return $term ? $term->term_id : 0;
	}

	/**
	 * Retrieves the Term for the current Semester
	 * @todo Throw an Exception when current term doesn't exist
	 * @return Current Term Code (e.g 2147)
	 *
	 */
	public static function getCurrentTerm(){
	    $term = self::getCurrentTermID();
	    return self::getTermFromTermID($term);

	}

	public static function getTermFromTermID($term_id) {
	    $term_codes = array(
	            1 => 'Winter',
	            3 => 'Spring',
	            5 => 'Summer',
	            7 => 'Fall'         
	        );

	        return $term_codes[$term_id[3]] . '-' . $term_id[0] . '0' . $term_id[1] . $term_id[2];
	}

	/**
	 * Generates the Term Code given the current Semester and Year. If the
	 * value of the term parameter is already a four-digit term code it will
	 * just return the value back without doing anything else.
	 *
	 * @todo Throw exceptions in each if block
	 * @param  string $term (e.g Fall-2014)
	 * @return Generated Term Code (e.g 2147)
	 *
	 */
	public static function generateTermCodeFromSemesterTerm($term){

		// does the term code already exist as a four-digit format?
		if(is_numeric($term) && strlen($term) == 4) {
			// return the term code back
			return $term;
		}

	    /*
	        Creating term code from semester and year (e.g Fall-2014):
	        1) Take the given year, and remove the digit in 
	            the century position (e.g 2014 becomes 214)
	        2) Grab the number associated with the term name
	            (e.g fall => 7, spring => 3)
	        3) Append the result from step 2 to the result
	            from step one. Fall-2014 => 2147.
	    */
	            
	    $term_codes = array(
	            'winter' => 1,
	            'spring' => 3,
	            'summer' => 5,
	            'fall' => 7         
	        );
	    $term_array = explode('-', $term);

	    //Is the term formatted correctly?
	    if(count($term_array) != 2){
	        //throw an exception!
	    }

	    $term_name = strtolower($term_array[0]);
	    //Is the given term name an actual term name?
	    if(!array_key_exists($term_name, $term_codes)){
	        //throw an exception!
	    }

	    //Is the year a 4 digit number?
	    if(!is_numeric($term_array[1]) || strlen($term_array[1]) != 4){
	        //throw an exception!
	    }

	    $term_year = $term_array[1];
	    $term_code = "2" . $term_year[2] . $term_year[3] . $term_codes[$term_name];

	    return $term_code;
	}

	/**
	 * Remove all keys from $array that are present in the $keys array.
	 * Elements in $keys can be paths using "dot" notation (e.g 'data.class_meeting.term_id').
	 * The array is directly modified.
	 * @param array $array (reference), array $keys
	 * @return No return value. Array is modified directly.
	 *
	 */
	public static function forgetArrayKeyValuePairs(&$array, $keys)
	{
	    for ($i=0; $i < count($keys); $i++) { 
	        array_forget($array, $keys[$i]);
	    }
	}

	/**
	 * Transforms collection of classes for to presentation response (API) array for classes
	 *
	 * @param collection $data 
	 * @return array
	 *
	 */
	public static function prepareClassesResponse($collection)
	{
		// grab all terms as an array so we can transform the ID into
		// an actual term name
		$terms = Term::all()->lists('term', 'term_id');
	    $classes = [];
	    foreach($collection as $class) {
	        $data = [
		        'class_number' => $class->class_number,
		        'subject' => $class->subject,
		        'catalog_number' => $class->catalog_number,
		        'section_number' => $class->section_number,
		        'title' => $class->title,
		        'course_id' => $class->course_id,
		        'description' => $class->description,
		        'units' => $class->units,
		        'term' => (array_key_exists($class->term_id, $terms) ? $terms[$class->term_id] : ""),
		        'class_type' => $class->class_type,
		        'enrollment_cap' => $class->enrollment_cap,
		        'enrollment_count' => $class->enrollment_count,
		        'waitlist_cap' => $class->waitlist_cap,
		        'waitlist_count' => $class->waitlist_total,
		        'meetings' => [],
		        'instructors' => []
            ];
	        foreach($class->meetings as $meeting) {
	            $meeting = [
	            'meeting_number' => $meeting->meeting_number,
	            'location' => $meeting->location,
	            'start_time' => $meeting->start_time,
	            'end_time' => $meeting->end_time,
	            'days' => $meeting->days,
                ];
	            $data['meetings'][] = $meeting;
	        }

	        foreach($class->instructors as $instructor) {
	            $instructors = [
	                'instructor' => $instructor->email
	            ];
	            $data['instructors'][] = $instructors;
	        }

	        $classes[] = $data;
	    }

	   return $classes;
	}

	/**
	 * Transforms collection of classes (uniqued to courses) to presentation response (API) array for courses
	 *
	 * @param collection $collection 
	 * @return array
	 *
	 */
	public static function prepareCoursesResponse($collection)
	{
		// grab all terms as an array so we can transform the ID into
		// an actual term name
		$terms = Term::all()->lists('term', 'term_id');

	    $courses = [];
	    foreach($collection as $_course) {
	        $data = [];
	        $data['subject'] = $_course->subject;
	        $data['catalog_number'] = $_course->catalog_number;
	        $data['section_number'] = $_course->section_number;
	        $data['title'] = $_course->title;
	        $data['course_id'] = $_course->course_id;
	        $data['description'] = $_course->description;
	        $data['units'] = $_course->units;
	        $data['term'] = (array_key_exists($_course->term_id, $terms) ? $terms[$_course->term_id] : "");
	        
	        $courses[] = $data;
	    }

	   return $courses; 
	}


	/**
	 * Returns the JSON response with optional response code. This method also
	 * logs the request information for statistical purposes.
	 *
	 * @param array $data The error data to send back to the browser
	 * @param integer $code Optional error response code to send back
	 *
	 * @return Response
	 */
	public static function sendErrorResponse($data, $code=500) {
		// additional data to add that should exist for all responses
		$additional = [
			'collection' => 'errors',
			'success' => 'false',
			'status' => $code
		];

		// add the additional data to the response if it does not
		// already exist
		foreach($additional as $key => $value) {
			$data = array_add($data, $key, $value);
		}

		// complete the response
		$data = array_reverse($data);
		//In the case of an error, a default version matching the latest version will be shown
		return self::sendResponse($data,'1.1');
	}

	/**
	 * Returns the JSON response with the response code. This method also
	 * logs the request information for statistical purposes.
	 *
	 * @param array $data The data to send back to the browser
	 * @return Response
	 */
    public static function sendResponse($data, $version) {
        // additional data to add that should exist for all responses
        $additional = [
            'version' => $version,
            'success' => 'true',
            'status' => '200',
            'api' => 'curriculum',

        ];

        // add the additional data to the response if it does not
        // already exist
        $data = array_reverse($data);
        foreach($additional as $key => $value) {
            $data = array_add($data, $key, $value);
        }
        $data = array_reverse($data);

        // grab the necessary Request information
        $ip = Request::ip();

        // resolve the URL portion beginning with /api to include the
        // query string provided, if any
        $path = urldecode(str_replace(Request::root(), "", Request::fullUrl()));

        // figure out the result count
        $dataCount = 0;
        if ($data['collection'] == 'classes') {
            $dataCount = count($data['classes']);
        } else if ($data['collection'] == 'courses') {
            $dataCount = count($data['courses']);
        } else if ($data['collection'] == 'plans') {
            $dataCount = count($data['plans']);
        }
        // log the request for statistical purposes
        LoggedRequest::create([
            'ip' => $ip,
            'path' => $path,
            'response_code' => $data['status'],
            'success' => ($data['success'] == 'true'), // string->boolean
            'results' => $dataCount
        ]);

        // now send the response code and data back
        return response($data, $data['status']);
    }

    //sendLegacyResponse is required if you need to return the JSON with 'type' as it did in version 1.0
    public static function sendLegacyResponse($data) {
        // additional data to add that should exist for all responses
        $additional = [
            'success' => 'true',
            'status' => '200',
            'api' => 'curriculum',
            'version' => '1.0'

        ];

        // add the additional data to the response if it does not
        // already exist
        $data = array_reverse($data);
        foreach($additional as $key => $value) {
            $data = array_add($data, $key, $value);
        }
        $data = array_reverse($data);

        // grab the necessary Request information
        $ip = Request::ip();

        // resolve the URL portion beginning with /api to include the
        // query string provided, if any
        $path = urldecode(str_replace(Request::root(), "", Request::fullUrl()));

        // figure out the result count
        $dataCount = 0;
        if($data['type'] == 'classes') {
            $dataCount = count($data['classes']);
        }
        else if($data['type'] == 'courses') {
            $dataCount = count($data['courses']);
        }
        else if($data['type'] == 'plans') {
            $dataCount = count($data['plans']);
        }

        // log the request for statistical purposes
        LoggedRequest::create([
            'ip' => $ip,
            'path' => $path,
            'response_code' => $data['status'],
            'success' => ($data['success'] == 'true'), // string->boolean
            'results' => $dataCount
        ]);

        // now send the response code and data back
        return response($data, $data['status']);
    }

	/**
	 * Checks if id is an association id (ie: classes:Summer-14:10472)
	 *
	 * @param mixed $id 
	 * @return boolean
	 *
	 */
	public static function isAssociationID($id) {
	    $pattern = '/^classes:(Spring|Summer|Fall|Winter)-[0-9][0-9]:[0-9]{5}$/';
	    return preg_match($pattern, $id);
	}

	/**
	 * Checks if id is a subject-catalog_number id (ie:comp-110L)
	 *
	 * @param mixed $id 
	 * @return boolean
	 *
	 */
	public static function isSubjectCatelogID($id) {
	    if (strpos($id,':') !== false) {
	        return false; // contains ':' not a subject
	    }

	    $id_array = explode('-', $id);
	    return (count($id_array)==2)?true:false;
	}

	/**
	 * Checks if id is a subject id (ie: comp)
	 *
	 * @param mixed $id 
	 * @return boolean
	 *
	 */
	public static function isSubjectID($id) {         
	    $pattern = '/^[a-zA-Z][a-zA-Z\/ ]*$/';
	    return preg_match($pattern, $id);
	}
}