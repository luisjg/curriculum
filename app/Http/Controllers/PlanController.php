<?php namespace Curriculum\Http\Controllers;

use Illuminate\Http\Request;

use Curriculum\Handlers\HandlerUtilities;
use Curriculum\Models\Plan;

class PlanController extends Controller {

	/**
	 * Constructs a new CourseController object.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get all degree plan information
	 * @link /api/plans 	GET
	 * @return all degree plans
	 *
	 */
	public function index(Request $request)
	{

    $version= $request->route()->getAction()['version'];
		$data = Plan::orderBy('name', 'ASC')->get();

		$response = array(
			'collection'		  => 'plans',
			'limit'		  => '150',
			'plans'	  	  => $data
		);

		return HandlerUtilities::sendResponse($response, $version);
	}

	/**
	 * Get all graduate degree plan information
	 * @link /api/plans/graduate 	GET
	 * @return all graduate degree plans
	 *
	 */
	public function graduateIndex(Request $request, $type)
	{
        $version= $request->route()->getAction()['version'];
		$data = Plan::where('plan_type', 'GRADUATE')
			->orderBy('name', 'ASC')
			->get();

		$response = array(
			'collection'		  => 'plans',
			'limit'		  => '150',
			'plans'	  	  => $data
		);
        if(strpos($request->url(),'api' ) == false){
            $response = array(
                'type'		  => 'plans',
                'plans'	  => $data
            );
            return HandlerUtilities::sendLegacyResponse($response);
        }

		return HandlerUtilities::sendResponse($response, $version);
	}

	/**
	 * Get all undergraduate degree plan information
	 * @link /api/plans/undergraduate	GET
	 * @return all undergraduate degree plans
	 *
	 */
	public function undergraduateIndex(Request $request, $type)
	{
        $version= $request->route()->getAction()['version'];
		$data = Plan::where('plan_type', 'UNDERGRADUATE')
			->orderBy('name', 'ASC')
			->get();

		$response = array(
			'collection'		  => 'plans',
			'limit'		  => '150',
			'plans'	  	  => $data
		);
        if(strpos($request->url(),'api' ) == false){
            $response = array(
                'type'		  => 'plans',
                'plans'	  => $data
            );
            return HandlerUtilities::sendLegacyResponse($response);
        }

		return HandlerUtilities::sendResponse($response, $version);
	}

	/**
	 * Get information for a specific degree plan
	 * @link /api/plans/{id} 	GET
	 * @param string $id
	 * @return information for a specific degree plan
	 *
	 */
	public function show($id, Request $request)
	{
        $version= $request->route()->getAction()['version'];
		$data = Plan::findOrFail($id);

		$response = array(
			'collection'    => 'plan',
			'plan'	  	    => $data
		);

        if(strpos($request->url(),'api' ) == false){
            $response = array(
                'type'	    => 'plans',
                'plans'	    => $data
            );
            return HandlerUtilities::sendLegacyResponse($response);
        }

		return HandlerUtilities::sendResponse($response, $version);
	}
	
}