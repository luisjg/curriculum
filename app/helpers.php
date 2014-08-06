<?php

/* Place all helper functions here */


/**
 * Retrieves the Term Code for the current Semester
 * @todo Throw an Exception when current term doesn't exist
 * @return Current Term Code (e.g 2147)
 *
 */
function getCurrentTermID(){
        $current_date = date("Y-m-d H:i:s");
        
        /* Get First term that that falls between these days */
        /* Note: muliple semesters avaiable at the same time during the summer and GRAD/UGRD */
        $term = Term::where('begin_date', '<=', $current_date)
                    ->where('end_date', '>', $current_date)
                    ->first(); 

        /* In between semesters, just use the last semester as default */
        if (!$term) {
            $term = SemesterTerm::where('end_date', '<', $current_date)->orderBy('end_date', 'desc')->first();
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
function getCurrentTerm(){
    $term = getCurrentTermID();
    return getTermFromTermID($term);

}

function getTermFromTermID($term_id) {
    $term_codes = array(
            1 => 'Winter',
            3 => 'Spring',
            5 => 'Summer',
            7 => 'Fall'         
        );

        return $term_codes[$term_id[3]] . '-' . $term_id[0] . '0' . $term_id[1] . $term_id[2];
}

/**
 * Generates the Term Code given the current Semester and Year
 * @todo Throw exceptions in each if block
 * @param  string $term (e.g Fall-2014)
 * @return Generated Term Code (e.g 2147)
 *
 */
function generateTermCodeFromSemesterTerm($term){

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
function forgetArrayKeyValuePairs(&$array, $keys)
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
function prepareClassesResponse($collection)
{   
    $classes = [];
    foreach($collection as $_class) {
        $data = [];
        $data['class_number'] = $_class->class_number;
        $data['subject'] = $_class->subject;
        $data['catalog_number'] = $_class->catalog_number;
        $data['section_number'] = $_class->section_number;
        $data['title'] = $_class->title;
        $data['course_id'] = $_class->course_id;
        $data['description'] = $_class->description;
        $data['units'] = $_class->units;
        $data['term'] = $_class->term;
        $data['meetings'] = [];
        $data['instructors'] = [];

        foreach($_class->meetings as $_meeting) {
            $meeting = [];
            $meeting['meeting_number'] = $_meeting->meeting_number;
            $meeting['location'] = $_meeting->location;
            $meeting['start_time'] = $_meeting->start_time;
            $meeting['end_time'] = $_meeting->end_time; 
            $meeting['days'] = $_meeting->days; 
            
            $data['meetings'][] = $meeting;

        }

        foreach($_class->instructors as $_instructor) {
            $instructor = [];
            $instructor['instructor'] = $_instructor->email;   
            
            $data['instructors'][] = $instructor;
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
function prepareCoursesResponse($collection)
{   
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
        $data['term'] = $_course->term;
        
        $courses[] = $data;
    }

   return $courses; 
}

/**
 * Checks if id is an association id (ie: classes:Summer-14:10472)
 *
 * @param mixed $id 
 * @return boolean
 *
 */
function isAssociationID($id) {
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
function isSubjectCatelogID($id) {
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
function isSubjectID($id) {         
    $pattern = '/^[a-zA-Z][a-zA-Z\/ ]*$/';
    return preg_match($pattern, $id);
}