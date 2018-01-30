<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Handlers\HandlerUtilities;
use App\Models\Plan;

class PlanController extends Controller 
{

	/**
	 * Get all degree plan information
	 * @link /api/plans 	GET
	 * @return all degree plans
	 *
	 */
	public function index(Request $request)
	{

	    $version= $request->route()[1]['version'];
		$data = Plan::orderBy('name', 'ASC')->get();

		$response = array(
			'collection'  => 'plans',
			'plans' => $data
		);

		return HandlerUtilities::sendResponse($response, $version, $request);
	}

	/**
	 * Get all graduate degree plan information
	 * @link /api/plans/graduate 	GET
	 * @return all graduate degree plans
	 *
	 */
	public function graduateIndex(Request $request)
	{
        $version= $request->route()[1]['version'];
		$data = Plan::where('plan_type', 'GRADUATE')
			->orderBy('name', 'ASC')
			->get();

		$response = array(
			'collection' => 'plans',
			'plans' => $data
		);
        if(strpos($request->url(),'api') == false) {
            $response = array(
                'type' => 'plans',
                'plans' => $data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
	}

	/**
	 * Get information for a specific degree plan
	 * @link /api/plans/{id} 	GET
	 * @param string $id
	 * @return information for a specific degree plan
	 *
	 */
	public function show(Request $request, $id)
	{
        $version= $request->route()[1]['version'];
		$data = Plan::findOrFail($id);

		$response = array(
			'collection' => 'plan',
			'plan' => $data
		);

        if(strpos($request->url(),'api') == false) {
            $response = array(
                'type' => 'plans',
                'plans' => $data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
	}
	
}