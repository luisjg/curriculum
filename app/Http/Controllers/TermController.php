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
	 * @link /term/{term}/classes 	GET
	 * @param string $term
	 * @return all classes, including the class_meeting and
	 *  class_instructors for those classes
	 *
	 */
	public function classesIndex($term)
	{
		$term = HandlerUtilities::generateTermCodeFromSemesterTerm($term);

		$data = Classes::with('meetings','instructors')
			->where('term_id', $term)
			->orderBy('subject')->orderBy('catalog_number');

		/* APPLY INSTRUCTOR FILTER */
		$instructor = Request::input('instructor', 0);
		if($instructor) {
			$data->hasInstructor($instructor);
		} else {
			$response = array(
				'status'      => 500,
				'success'	  => false,
				'version'     => config('app.api_version'),
				'type'		  => 'errors',
				'errors'	  => ['No filter paramters set']
			);

			return response($response, 500);
		}
	
		$prepped_data = HandlerUtilities::prepareClassesResponse($data->get());
		
		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => config('app.api_version'),
			'type'		  => 'classes',
			'classes'	  => $prepped_data
		);

		return response($response, 200);
	}

	/**
	 * Get class information for a specific class if a ticket number is given,
	 *	or class information for all classes with a specific subject and
	 *	catalog_number if subject-catalog_number is given. All the information
	 *  is for the current term
	 * @link /term/{term}/classes/{id} 	GET
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

		$data = Classes::with('meetings', 'instructors')
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
			'status'      => 200,
			'success'	  => true,
			'version'     => config('app.api_version'),
			'type'		  => 'classes',
			'classes'	  => $prepped_data
		);

		return response($response, 200);
	}

	/**
	 * Get all course information for the given term
	 * @link /term/{term}/courses 	GET
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
			'status'      => 200,
			'success'	  => true,
			'version'     => config('app.api_version'),
			'type'		  => 'courses',
			'courses'	  => $prepped_data
		);

		return response($response, 200);
	}

	/**
	 * Get course information for a specific course given a subject,
	 * all for the given term
	 * @link /term/{term}/courses/{id} 	GET
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
			'status'      => 200,
			'success'	  => true,
			'version'     => config('app.api_version'),
			'type'		  => 'courses',
			'courses'	  => $prepped_data
		);

		return response($response, 200);
	}
	
}