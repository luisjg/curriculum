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

}