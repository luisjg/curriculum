<?php namespace Curriculum\Http\Controllers;

use Request;

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
	public function index()
	{
        $id = Request::input('id', 0);
        if($id){
            $data = Plan::findOrFail($id);
}
        else{
            $data = Plan::orderBy('name', 'ASC')->get();
    }


		$response = array(
			'type'		  => 'plans',
			'limit'		  => '150',
			'plans'	  	  => $data
		);

		return HandlerUtilities::sendResponse($response);
	}

	/**
	 * Get all graduate degree plan information
	 * @link /api/plans/graduate 	GET
	 * @return all graduate degree plans
	 *
	 */
	public function graduateIndex()
	{
		$data = Plan::where('plan_type', 'GRADUATE')
			->orderBy('name', 'ASC')
			->get();

		$response = array(
			'type'		  => 'plans',
			'limit'		  => '150',
			'plans'	  	  => $data
		);

		return HandlerUtilities::sendResponse($response);
	}

	/**
	 * Get information for a specific degree plan
	 * @link /api/plans/{id} 	GET
	 * @param string $id
	 * @return information for a specific degree plan
	 *
	 */
	public function show($id)
	{
		$data = Plan::findOrFail($id);

		$response = array(
			'type'		  => 'plan',
			'plan'	  	  => $data
		);

		return HandlerUtilities::sendResponse($response);
	}
	
}