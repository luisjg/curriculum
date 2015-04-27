<?php namespace Curriculum\Http\Controllers;

use Request;

use Curriculum\Handlers\HandlerUtilities;
use Curriculum\Models\Classes;

class CourseController extends Controller {

	/**
	 * Constructs a new CourseController object.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get all course information for the current term
	 * @link /courses 	GET
	 * @internal don't allow entire course list for all semesters to be returned without a subject 
	 * 				until paging or some way to restrict these results is added
	 * @return all courses for the current term
	 *
	 */
	public function index()
	{
		$term = HandlerUtilities::getCurrentTermID();
		
		$data = Classes::groupAsCourse($term, false)
			->orderBy('subject')->orderBy('catalog_number');

		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());

		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'curriculum-1.0',
			'type'		  => 'courses',
			'limit'		  => '50',
			'courses'	  => $prepped_data
		);

		return response($response, 200);
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
		$term = HandlerUtilities::getCurrentTermID();

		$data = Classes::whereIdentifier($id)
			->groupAsCourse($term, Request::get('showAll', false))
			->orderBy('subject')->orderBy('catalog_number');

		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());
		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'curriculum-1.0',
			'type'		  => 'courses',
			'courses'	  => $prepped_data
		);

		return response($response, 200);
	}
	
}