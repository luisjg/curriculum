<?php namespace Curriculum\Http\Controllers;


use Illuminate\Http\Request;

use Curriculum\Handlers\HandlerUtilities;
use Curriculum\Models\Classes,
	Curriculum\Models\Term;
use Curriculum\Models\ClassMembershipRoster;

class ClassController extends Controller {

	/**
	 * Constructs a new ClassController object.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get all class information from the current term
	 * @link /api/classes 	GET
	 * @return all classes, including the class_meeting and
	 * class_instructors for those classes
	 *
	 */
	public function index(Request $request)
	{
        $version= $request->route()->getAction()['version'];
		$term = Term::current();
		$term_id = ($term ? $term->term_id : 0);
		$data = Classes::with('meetings', 'instructors')->where('term_id', $term_id);

		/* APPLY INSTRUCTOR FILTER */
		$instructor = $request->input('instructor', false);
		if($instructor) {
			$data->hasInstructor($instructor);
		} else {
			$response = array(
				'errors'	  => ['No filter parameters set']
			);

			return HandlerUtilities::sendErrorResponse($response);
		}
	
		$prepped_data = HandlerUtilities::prepareClassesResponse($data->get());

		$response = array(
            'collection'	  => 'classes',
			'classes'	  => $prepped_data
		);
        if(strpos($request->url(),'api' ) == false){
            $response = array(
                'type'		  => 'classes',
                'classes'	  => $prepped_data
            );
            return HandlerUtilities::sendLegacyResponse($response);
        }

		return HandlerUtilities::sendResponse($response,$version);
	}

	/**
	 * Get class information for a specific class if a ticket number is given,
	 *	or class information for all classes with a specific subject and
	 *	catalog_number if subject-catalog_number is given. All the information
	 *  is for the current term
	 * @todo Exceptions in else block, and is_numeric check on ticket number
	 * @link /api/classes/{id} 	GET
	 * @internal Examples of possible $id
	 *		NAME 					EXAMPLE			 
	 *		association_id			classes:Summer-14:10472 		
	 * 		class_number			10402
	 *		subject 				comp
 	 *		subject-catalog_number 	comp-160
	 * @param int|string $id
	 * @return class
	 *
	 */
	public function show($id, Request $request)
	{
        $version= $request->route()->getAction()['version'];

		$term = Term::current();
		$term_id = ($term ? $term->term_id : 0);
        if(env('APP_ENV')=='testing'){
            $term_id =env('TESTING_TERM');
        }
		$data = Classes::with('meetings', 'instructors','enrolled')

			->where('term_id', $term_id)
			->whereIdentifier($id);

		/* APPLY INSTRUCTOR FILTER */

		$instructor = $request->input('instructor', false);

		if($instructor) {
			$data->hasInstructor($instructor);
		}

		$prepped_data = HandlerUtilities::prepareClassesResponse($data->get());

		$response = array(
			'collection'	=> 'classes',
			'classes'	    => $prepped_data
		);

        if(strpos($request->url(),'api' ) == false){
            $response = array(
                'type'		  => 'classes',
                'classes'	  => $prepped_data
            );
            return HandlerUtilities::sendLegacyResponse($response);
        }

		return HandlerUtilities::sendResponse($response,$version);
	}
}