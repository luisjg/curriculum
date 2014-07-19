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
		$term = getCurrentTermID();
		
		$data = Classes::groupBy('term_id')->groupBy('course_id')
			->having('term_id', '=', $term)
			->orderBy('subject')->orderBy('catalog_number');

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
		$term = getCurrentTermID();

		$data = Classes::whereIdentifier($id)
			->groupBy('term_id')->groupBy('course_id')
			->having('term_id', '=', $term)
			->orderBy('subject')->orderBy('catalog_number');

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