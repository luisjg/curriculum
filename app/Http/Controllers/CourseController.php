<?php namespace Curriculum\Http\Controllers;

use Request;

use Curriculum\Handlers\HandlerUtilities;
use Curriculum\Models\Classes,
	Curriculum\Models\Term;

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
		//$term = HandlerUtilities::getCurrentTermID();
		$term = Term::current();
		$term_id = ($term ? $term->term_id : 0);
		
		$data = Classes::groupAsCourse($term_id, false)
			->orderBy('subject')->orderBy('catalog_number');

		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());

		$response = array(
			'type'		  => 'courses',
			'limit'		  => '50',
			'courses'	  => $prepped_data
		);

		return HandlerUtilities::sendResponse($response);
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
		//$term = HandlerUtilities::getCurrentTermID();
		$term = Term::current();
		$term_id = ($term ? $term->term_id : 0);

		$data = Classes::whereIdentifier($id)
			->groupAsCourse($term_id, Request::input('showAll', false))
			->orderBy('subject')->orderBy('catalog_number');

		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());
		$response = array(
			'type'		  => 'courses',
			'courses'	  => $prepped_data
		);

		return HandlerUtilities::sendResponse($response);
	}
	
}