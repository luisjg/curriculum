<?php

class ClassController extends \BaseController {

	/**
	 * Get all class information from the current term
	 * @link /classes 	GET
	 * @return all classes, including the class_meeting and
	 * class_instructors for those classes
	 *
	 */
	public function index()
	{
		$term = getCurrentTermID();

		$data = Classes::withMeetings($term)
			->withInstructors($term)
			->where('term_id', $term);

		/* APPLY INSTRUCTOR FILTER */
		$instructor = Input::get('instructor', 0);
		if($instructor) {
			$data->hasInstructor($instructor, $term);
		}
	
		$prepped_data = prepareClassesResponse($data->get());

		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'omar-1.0',
			'type'		  => 'classes',
			'classes'	  => $prepped_data
		);

		return Response::make($response, 200);
	}

	/**
	 * Get class information for a specific class if a ticket number is given,
	 *	or class information for all classes with a specific subject and
	 *	catalog_number if subject-catalog_number is given. All the information
	 *  is for the current term
	 * @todo Exceptions in else block, and is_numeric check on ticket number
	 * @link /classes/{id} 	GET
	 * @param int|string $id
	 * @return class info given ticket number|subject|subject-catalog_number, 
	 * 			all for the current term
	 *
	 */
	public function show($id)
	{
		$term = getCurrentTermID();

		$data = Classes::withMeetings($term)
			->withInstructors($term)
			->where('term_id', $term);

		$id_array = explode('-', $id);
		$id_array_size = count($id_array);

		if ($id_array_size == 1)
		{
			if (is_numeric($id)) { // is the $id a ticket number?
				$data = $data->where('class_number', $id);
			} else { // is the $id a subject?
				$data = $data->where('subject', $id);
			}
		} 
		elseif ($id_array_size == 2) // is the $id a subject-catalog_number?
		{ 
			$subject = $id_array[0];
			$catalog_number = $id_array[1];
			$data = $data->where('subject', $subject)->where('catalog_number', $catalog_number);
		} 
		else 
		{
			//throw some stuff
		}

		/* APPLY INSTRUCTOR FILTER */
		$instructor = Input::get('instructor', 0);
		if($instructor) {
			$data->hasInstructor($instructor, $term);
		}

		$prepped_data = prepareClassesResponse($data->get());

		$response = array(
			'status'      => 200,
			'success'	  => true,
			'version'     => 'omar-1.0',
			'type'		  => 'classes',
			'classes'	  => $prepped_data
		);

		return Response::make($response, 200);
	}
	
}