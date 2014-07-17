<?php

class TermController extends \BaseController {

	/**
	 * Get all class information from the given term
	 * @link /term/{term}/classes 	GET
	 * @param string $term
	 * @return all classes, including the class_meeting and
	 *  class_instructors for those classes
	 *
	 */
	public function classesIndex($term)
	{
		$term_code = generateTermCodeFromSemesterTerm($term);

		$data = Classes::with([
			'meetings' => function($query) use ($term_code) {
				$query->where('term_id', $term_code);
			}, 
			'instructors' => function($query) use ($term_code) {
				$query->where('term_id', $term_code);
			}
		])->where('term_id', $term_code);

		/* APPLY INSTRUCTOR FILTER */
		$instructor = Input::get('instructor', 0);
		if($instructor) {
			$data->hasInstructor($instructor, $term);
		}

		$data = $data->get()->toArray();
		prepareClassesResponse($data);

		
		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'omar-1.0',
			'type'		  => 'classes',
			'classes'	  => $data
		);

		return Response::make($response, 200);
	}

	/**
	 * Get class information for a specific class if a ticket number is given,
	 *	or class information for all classes with a specific subject and
	 *	catalog_number if subject-catalog_number is given. All the information
	 *  is for the current term
	 * @todo Exceptions in else block, and is_numeric check on ticket number
	 * @link /term/{term}/classes/{id} 	GET
	 * @param string $term, int|string $id
	 * @return class info for ticket number|subject-catalog_number for the given term
	 *
	 */
	public function classesShow($term, $id)
	{
		$term_code = generateTermCodeFromSemesterTerm($term);

		$data = Classes::with([
			'meetings' => function($query) use ($term_code) {
				$query->where('term_id', $term_code);
			}, 
			'instructors' => function($query) use ($term_code) {
				$query->where('term_id', $term_code);
			}
		])->where('term_id', $term_code);

		$id_array = explode('-', $id);
		$id_array_size = count($id_array);

		if ($id_array_size == 1)
		{
			if (is_numeric($id)) { // is the $id a ticket number?
				$data = $data->where('class_number', $id);
			} else { // is the $id a subject?
				$data = $data->where('subject', $id);
			}
		} 
		elseif ($id_array_size == 2) // is the $id a subject-catalog_number?
		{
			$subject = $id_array[0];
			$catalog_number = $id_array[1];
			$data = $data->where('subject', $subject)->where('catalog_number', $catalog_number);
		}
		else
		{
			//throw some stuff
		}

		$data = $data->get()->toArray();
		prepareClassesResponse($data);

		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'omar-1.0',
			'type'		  => 'classes',
			'classes'	  => $data
		);

		return Response::make($response, 200);
	}

	/**
	 * Get all course information for the given term
	 * @link /term/{term}/courses 	GET
	 * @internal {term} looks like [semester (fall, spring, etc)]-[year]
	 * @return all courses for the given term
	 *
	 */
	public function coursesIndex($term)
	{
		$term_code = generateTermCodeFromSemesterTerm($term);
		
		$data = Classes::groupBy('term_id')->groupBy('course_id')
			->having('term_id', '=', $term_code)
			->orderBy('subject')->orderBy('catalog_number')
			->get()
			->toArray();

		prepareCoursesResponse($data);

		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'omar-1.0',
			'type'		  => 'courses',
			'courses'	  => $data
		);

		return Response::make($response, 200);
	}

	/**
	 * Get course information for a specific course given a subject,
	 * all for the given term
	 * @todo Exceptions in else block
	 * @link /term/{term}/courses/{id} 	GET
	 * @param string $id
	 * @return course info for a subject, all for the given term
	 *
	 */
	public function coursesShow($term, $id)
	{
		$term_code = generateTermCodeFromSemesterTerm($term);

		$data = Classes::groupBy('term_id')->groupBy('course_id')
			->having('term_id', '=', $term_code)
			->orderBy('subject')->orderBy('catalog_number');

		$id_array = explode('-', $id);
		$id_array_size = count($id_array);

		if ($id_array_size == 1) // is the $id a subject?
		{
			$data = $data->where('subject', $id);
		} 
		elseif ($id_array_size == 2) // is the $id a subject-catalog_number
		{
			$subject = $id_array[0];
			$catalog_number = $id_array[1];
			$data = $data->where('subject', $subject)->where('catalog_number', $catalog_number);
		}
		else
		{
			//throw some stuff
		}

		$data = $data->get()->toArray();
		prepareCoursesResponse($data);

		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'omar-1.0',
			'type'		  => 'courses',
			'courses'	  => $data
		);

		return Response::make($response, 200);
	}
	
}