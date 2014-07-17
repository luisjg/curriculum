<?php

/* Place all helper functions here */


/**
 * Retrieves the Term Code for the current Semester
 * @todo Throw an Exception when current term doesn't exist
 * @return Current Term Code (e.g 2147)
 *
 */
function getCurrentTermCode(){
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
            
    $term_codes = array('fall' => 7, 'spring' => 3);
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
 *  Removes term_id from top level of the JSON, and also removes term_id
 *  and class_number from the lower levels of the JSON (class_meeting 
 *  and each instructor in class_instructors) before sending back the
 *  JSON response
 * @param array $data (reference)
 * @return No return value. Array is modified directly.
 *
 */
function prepareClassesResponse(&$data)
{
    for ($i=0; $i < count($data); $i++) { 
        forgetArrayKeyValuePairs($data[$i], 
            array(
                'term_id'                
            )
        );
        for ($j=0; $j < count($data[$i]['meetings']); $j++) { 
            forgetArrayKeyValuePairs($data[$i]['meetings'],
                array(
                    $j . '.term_id',
                    $j . '.class_number'
                )
            );
        }
        for ($j=0; $j < count($data[$i]['instructors']); $j++) { 
            forgetArrayKeyValuePairs($data[$i]['instructors'],
                array(
                    $j . '.term_id', 
                    $j . '.class_number'
                )
            );
        }
    }
}


/**
 * Remove term_id and class_number from top level of the JSON
 * @param array $array (reference)
 * @return No return value. Array is modified directly
 *
 */
function prepareCoursesResponse(&$data)
{
    for ($i=0; $i < count($data); $i++) { 
        forgetArrayKeyValuePairs($data[$i], 
            array(
                'term_id',
                'class_number'
            )
        );
    }
}

/**
 * Remove all classes from $data that do NOT contain
 * $instructor in it's list of class_instructors
 * @param string $instructor, array $data (reference)
 * @return No return value. Array is modified directly
 *
 */ 
function filterClassesByInstructor($instructor, &$data)
{
    $num_classes = count($data);
    for ($i=0; $i < $num_classes; $i++) {

        $instructors = $data[$i]['class_instructors'];
        $instructor_exists = false;
        for ($j=0; $j < count($instructors); $j++) { 
            if(trim($instructors[$j]['instructor']) == $instructor){
                $instructor_exists = true;
                break;
            }
        }
        if (!$instructor_exists){
            unset($data[$i]);
        }
    }
    $data = array_values($data);
}