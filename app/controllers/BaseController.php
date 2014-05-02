<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	/**
	 * Retrieves the Term Code for the current Semester
	 * @todo Throw ModelNotFoundException when current term doesn't exist
	 * @return Current Term Code (e.g 2147)
	 *
	 */
	function getCurrentTermCode(){
		$current_date = date("Y-m-d H:i:s");

		//Handle ModelNotFoundException
		$term = Term::where('begin_date', '<=', $current_date)
					->where('end_date', '>', $current_date)
					->firstOrFail()
					->sterm;

		return $term;
	}

	/**
	 * Generates the Term Code given the current Semester and Year
	 * @todo Throw exceptions in each if check
	 * @param  string $term (e.g Fall-2014)
	 * @return Generated Term Code (e.g 2147)
	 *
	 */
	function generateTermCodeFromSemesterTerm($term){

		/*
			Creating term code from semester and year:
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

	/*
		Remove all keys from $array that are present in the $keys array.
		Elements in $keys can be paths using "dot" notation.
	*/
	function forgetArrayKeyValuePairs(&$array, $keys)
	{
		for ($i=0; $i < count($keys); $i++) { 
			array_forget($array, $keys[$i]);
		}
	}

	//Removes unwanted array properties before sending back the JSON response
	function prepareClassesResponse(&$data)
	{
		for ($i=0; $i < count($data); $i++) { 

			$this->forgetArrayKeyValuePairs($data[$i], 
				array(
					'sterm',
					'class_meeting.sterm',
					'class_meeting.class_number'
				)
			);

			for ($j=0; $j < count($data[$i]['class_instructors']); $j++) { 
				$this->forgetArrayKeyValuePairs($data[$i]['class_instructors'],
					array(
						$j . '.sterm', 
						$j . '.class_number', 
						$j . '.emplid', 
						$j . '.instructor_role'
					)
				);
			}
		}
	}

	function prepareCoursesResponse(&$data)
	{
		for ($i=0; $i < count($data); $i++) { 
			$this->forgetArrayKeyValuePairs($data[$i], 
				array(
					'sterm',
					'class_number'
				)
			);
		}
	}


	/*
		Remove all classes from $data that do NOT contain
		$instructor in it's list of class_instructors
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

	function removeDuplicateClasses(&$array)
	{
		$unique_classes = array();
		for ($i=0; $i < count($array); $i++) { 
			$key = $array[$i]['subject'] . $array[$i]['catalog_number'];
			if(!array_key_exists($key, $unique_classes)){
				$unique_classes[$key] = $array[$i];
			}
		}
		$array = array_values($unique_classes);
	}


}













