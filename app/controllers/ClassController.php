<?php

class ClassController extends \BaseController {

	/**
	 * Get all class information from the current term
	 * @link /classes 	GET
	 * @return all classes, classmeetings, and classinstructors
	 *				from the given current term
	 *
	 */
	public function index()
	{
		$term = $this->getCurrentTermCode();
		$data = Classes::with(
			array(
				'classmeeting' => function($query) use ($term) {
					$query->where('sterm', $term);
				}, 
				'classinstructors' => function($query) use ($term) {
					$query->where('sterm', $term);
				}
			)
		)->where('sterm', $term);

		$response = array(
			'success'	  => true,
			'data'	      => $data->get()->toArray(),
			'status'      => 200
		);

		return Response::make($response, 200);

	}

	/**
	 * Get class information for a specific class if a ticket number is given,
	 *	or class information for all classes with a specific subject and
	 *	catalog_number if subject-catalog_number is given, all for the given term
	 * @todo Exceptions in else block, and is_numeric check on ticket number
	 * @link /classes/{id} 	GET
	 * @param int|string $id
	 * @return class info for ticket number|subject-catalog_number for the given term
	 *
	 */
	public function show($id)
	{
		$term = $this->getCurrentTermCode();
		$data = Classes::with(
			array(
				'classmeeting' => function($query) use ($term) {
					$query->where('sterm', $term);
				}, 
				'classinstructors' => function($query) use ($term) {
					$query->where('sterm', $term);
				}
			)
		)->where('sterm', $term);

		$id_array = explode('-', $id);
		$id_array_size = count($id_array);

		//Is the $id a ticket number?
		if($id_array_size == 1){
			//Add is_numeric check?
			$data = $data->where('class_number', $id);
		} 

		//Is the $id a subject-catalog_number
		elseif($id_array_size == 2){
			$subject = $id_array[0];
			$catalog_number = $id_array[1];
			$data = $data->where('subject', $subject)->where('catalog_number', $catalog_number);

		} else{
			//throw some stuff
		}

		$response = array(
			'success'	  => true,
			'data'	      => $data->get()->toArray(),
			'status'      => 200
		);

		return Response::make($response, 200);

	}
}