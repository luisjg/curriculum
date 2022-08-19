<?php
/*  Curriculum Web Service - Backend that delivers CSUN class and course information.
 *  Copyright (C) 2014-2019 - CSUN META+LAB
 *
 *  Waldo Web Service is free software: you can redistribute it and/or modify it under the terms
 *  of the GNU General Public License as published by the Free Software Found-
 *  ation, either version 3 of the License, or (at your option) any later version.
 *
 *  RetroArch is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *  PURPOSE.  See the GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along with RetroArch.
 *  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Http\Controllers;

use App\Handlers\HandlerUtilities;
use App\Models\Plan;
use Illuminate\Http\Request;

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
        if($version < 2.0) {
            $response = array(
                'type' => 'plans',
                'plans' => $data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
	}

    /**
     * Get all undergraduate degree plan information
     * @link /api/plans/undergraduate  GET
     * @return all undergraduate degree plans
     *
     */
    public function undergraduateIndex(Request $request)
    {
        $version= $request->route()[1]['version'];
        $data = Plan::where('plan_type', 'UNDERGRADUATE')
            ->orderBy('name', 'ASC')
            ->get();

        $response = array(
            'collection' => 'plans',
            'limit' => '150',
            'plans' => $data
        );
        if($version < 2.0) {
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
	 * @link /api/plans/{plan} 	GET
	 * @param string $plan
	 * @return information for a specific degree plan
	 *
	 */
	public function show(Request $request, $plan)
	{
        $version= $request->route()[1]['version'];
		$data = Plan::findOrFail($plan);

		$response = array(
			'collection' => 'plan',
			'plan' => $data
		);

        if($version < 2.0) {
            $response = array(
                'type' => 'plans',
                'plans' => $data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
	}
	
}