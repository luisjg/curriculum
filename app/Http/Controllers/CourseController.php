<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;;
use App\Handlers\HandlerUtilities;
use App\Models\Classes,
	App\Models\Course,
	App\Models\Term;


class CourseController extends Controller
{

    /**
     * Get all course information for the current term
     * @link /api/courses    GET
     * @internal don't allow entire course list for all semesters to be returned without a subject
     *                until paging or some way to restrict these results is added
     * @param Request $request
     * @return all courses for the current term
     */
	public function index(Request $request)
	{
        $version= $request->route()[1]['version'];
		$term = Term::current();
		$term_id = ($term ? $term->term_id : 0);
		$id = $request->input('id', 0);
		if($id) {
            $data = Classes::whereIdentifier($id)
                ->groupAsCourse($term_id, $request->input('showAll', false))
                ->orderBy('subject')->orderBy('catalog_number');
        } else {
            $data = Classes::groupAsCourse($term_id, false)
                ->orderBy('subject')->orderBy('catalog_number');
        }


		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());

		$response = array(
			'collection' => 'courses',
			'limit' => '50',
			'courses' => $prepped_data
		);
        if(strpos($request->url(),'api' ) == false) {
            $response = array(
                'type' => 'courses',
                'courses' => $prepped_data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
	}

	/**
	 * Get course information for a specific course, given a subject,
	 *  for the current term
	 * @todo Exceptions in else block
	 * @link /api/courses/{id} 	GET
	 * @param string $id
	 * @return response info for a subject, all for the current term
	 *
	 */
	public function show($id, Request $request)
	{
        $version= $request->route()[1]['version'];
		$term = Term::current();
		$term_id = ($term ? $term->term_id : 0);
		$data = Classes::whereIdentifier($id)
			->groupAsCourse($term_id, $request->input('showAll', false))
			->orderBy('subject')->orderBy('catalog_number');

		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());
		$response = array(
			'collection' => 'courses',
			'courses' => $prepped_data
		);

        if(strpos($request->url(),'api' ) == false) {
            $response = array(
                'type' => 'courses',
                'courses' => $prepped_data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
	}
	
}