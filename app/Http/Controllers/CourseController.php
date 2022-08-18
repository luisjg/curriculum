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
use App\Models\Classes;
use App\Models\Term;
use Illuminate\Http\Request;


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
		$showAll = ($request->get('showAll') === null) ? false : $request->get('showAll');
		if($id) {
            $data = Classes::whereIdentifier($id)
                ->groupAsCourse($term_id, $showAll);
        } else {
            $data = Classes::groupAsCourse($term_id, false);
        }


		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());

		$response = array(
			'collection' => 'courses',
			'limit' => '50',
			'courses' => $prepped_data
		);
        if($version < 2.0) {
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
		$showAll = ($request->get('showAll') === null) ? false : $request->get('showAll');
		$data = Classes::whereIdentifier($id)
			->groupAsCourse($term_id, $showAll);

		$prepped_data = HandlerUtilities::prepareCoursesResponse($data->get());
		$response = array(
			'collection' => 'courses',
			'courses' => $prepped_data
		);

        if($version < 2.0) {
            $response = array(
                'type' => 'courses',
                'courses' => $prepped_data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
	}
	
}