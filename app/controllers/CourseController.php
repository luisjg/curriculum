<?php

class CourseController extends \BaseController {

	/**
	 * Get all course information for the current term
	 * @link /courses 	GET
	 * @return all courses for the current term
	 *
	 */
	public function index()
	{
		$term = getCurrentTermCode();
		
		$data = Classes::groupBy('term_id')->groupBy('course_id')
			->having('term_id', '=', $term)
			->orderBy('subject')->orderBy('catalog_number')->take(50);

		$prepped_data = prepareCoursesResponse($data->get());

		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'omar-1.0',
			'type'		  => 'courses',
			'courses'	  => $prepped_data
		);

		return Response::make($response, 200);
	}

	/**
	 * Get course information for a specific course, given a subject,
	 *  for the current term
	 * @todo Exceptions in else block
	 * @link /courses/{id} 	GET
	 * @param string $id
	 * @return course info for a subject, all for the current term
	 *
	 */
	public function show($id)
	{
		$term = getCurrentTermCode();

		$data = Classes::groupBy('term_id')->groupBy('course_id')
			->having('term_id', '=', $term)
			->orderBy('subject')->orderBy('catalog_number');

		$id_array = explode('-', $id);
		$id_array_size = count($id_array);

		if ($id_array_size == 1) // is the $id a ticket number?
		{
			//Add is_numeric check?
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

		$prepped_data = prepareCoursesResponse($data->get());

		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'omar-1.0',
			'type'		  => 'courses',
			'courses'	  => $prepped_data
		);

		return Response::make($response, 200);
	}
	
}