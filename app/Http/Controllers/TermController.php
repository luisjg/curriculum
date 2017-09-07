<?php namespace Curriculum\Http\Controllers;

use Request;

use Curriculum\Handlers\HandlerUtilities;
use Curriculum\Models\Classes;

class TermController extends Controller {

	/**
	 * Constructs a new TermController object.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get all class information from the given term
	 * @link /api/term/{term}/classes 	GET
	 * @param string $term
	 * @return all classes, including the class_meeting and
	 *  class_instructors for those classes
	 *
	 */
	public function classesIndex($term)
	{
		$term = HandlerUtilities::generateTermCodeFromSemesterTerm($term);

		$data = Classes::with('meetings','instructors','enrolled')
			->where('term_id', $term)
			->orderBy('subject')->orderBy('catalog_number');

		/* APPLY INSTRUCTOR FILTER */
		$instructor = Request::input('instructor', 0);
		if($instructor) {
			$data->hasInstructor($instructor);
		} else {
			$response = array(
				'errors'	  => ['No filter paramters set']
			);

			return HandlerUtilities::sendErrorResponse($response);
		}
	
		$prepped_data = HandlerUtilities::prepareClassesResponse($data->get());
		
		$response = array(
			'type'		  => 'classes',
			'classes'	  => $prepped_data
		);

		return HandlerUtilities::sendResponse($response);
	}

	/**
	 * Get class information for a specific class if a ticket number is given,
	 *	or class information for all classes with a specific subject and
	 *	catalog_number if subject-catalog_number is given. All the information
	 *  is for the current term
	 * @link /api/term/{term}/classes/{id} 	GET
	 * @internal Examples of possible $id
	 *		NAME 					EXAMPLE			 
	 *		association_id			classes:Summer-14:10472 		
	 * 		class_number			10402
	 *		subject 				comp
 	 *		subject-catalog_number 	comp-160
	 * @param string $term, int|string $id
	 * @return class info for ticket number|subject-catalog_number for the given term
	 *
	 */
	public function classesShow($term, $id)
	{
		$term_id = HandlerUtilities::generateTermCodeFromSemesterTerm($term);

		$data = Classes::with('meetings', 'instructors','enrolled')
			->where('term_id', $term_id)
			->whereIdentifier($id)
			->orderBy('subject')->orderBy('catalog_number');

		/* APPLY INSTRUCTOR FILTER */
		$instructor = Request::input('instructor', 0);
		if($instructor) {
			$data->hasInstructor($instructor);
		}
		$prepped_data = HandlerUtilities::prepareClassesResponse($data->get());

		$response = array(
			'type'		  => 'classes',
			'classes'	  => $prepped_data
		);

		return HandlerUtilities::sendResponse($response);
	}

	/**
	 * Get all course information for the given term
	 * @link /api/term/{term}/courses 	GET
	 * @internal {term} looks like [semester (fall, spring, etc)]-[year]
	 * @internal don't allow entire course list for all semesters to be returned without a subject 
	 * 				until paging or some way to restrict these results is added
	 * @return all courses for the given term
	 *
	 */
	public function coursesIndex($term)
	{
		$term_code = HandlerUtilities::generateTermCodeFromSemesterTerm($term);
		
		$data = Classes::groupAsCourse($term_code, false)
			->orderBy('subject')->orderBy('catalog_number')
			->get()
			->toArray();

		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());

		$response = array(
			'type'		  => 'courses',
			'courses'	  => $prepped_data
		);

		return HandlerUtilities::sendResponse($response);
	}

	/**
	 * Get course information for a specific course given a subject,
	 * all for the given term
	 * @link /api/term/{term}/courses/{id} 	GET
	 * @internal Examples of possible $id
	 *		NAME 					EXAMPLE			 
	 *		association_id			classes:Summer-14:10472 		
	 * 		class_number			10402
	 *		subject 				comp
 	 *		subject-catalog_number 	comp-160
	 * @param string $id
	 * @return course info for a subject, all for the given term
	 *
	 */
	public function coursesShow($term, $id)
	{
		$term_code = HandlerUtilities::generateTermCodeFromSemesterTerm($term);

		$data = Classes::whereIdentifier($id)
			->groupAsCourse($term_code, Request::input('showAll',false))
			->orderBy('subject')->orderBy('catalog_number');


		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());

		$response = array(
			'type'		  => 'courses',
			'courses'	  => $prepped_data
		);

		return HandlerUtilities::sendResponse($response);
	}
	
}