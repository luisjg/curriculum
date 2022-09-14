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

class ClassController extends Controller
{

	/**
	 * Get all class information from the current term
	 * @link /api/classes 	GET
	 * @return all classes, including the class_meeting and
	 * class_instructors for those classes
	 *
	 */
	public function index(Request $request)
	{
        $version= $request->route()[1]['version'];
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

			return HandlerUtilities::sendErrorResponse($response, $request);
		}
	
		$prepped_data = HandlerUtilities::prepareClassesResponse($data->get());

		$response = array(
            'collection' => 'classes',
			'classes' => $prepped_data
		);
        if($version < 2.0) {
            $response = array(
                'type'		  => 'classes',
                'classes'	  => $prepped_data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
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
        $version= $request->route()[1]['version'];
		$term = Term::current();
		$term_id = ($term ? $term->term_id : 0);
        if(config('app.env')=='testing'){
            $term_id = config('app.testing_term');
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
			'collection' => 'classes',
			'classes' => $prepped_data
		);

        if($version < 2.0) {
            $response = array(
                'type' => 'classes',
                'classes' => $prepped_data
            );
            return HandlerUtilities::sendLegacyResponse($response, $request);
        }

		return HandlerUtilities::sendResponse($response, $version, $request);
	}
}