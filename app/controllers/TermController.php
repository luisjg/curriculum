<?php

class TermController extends \BaseController {

	/**
	 * Get all class information from the given term
	 * @link /term/{term}/classes 	GET
	 * @param string $term
	 * @return all classes, classmeetings, and classinstructors
	 *				from the given $term 
	 *
	 */
	public function index($term)
	{
		$term_code = $this->generateTermCodeFromSemesterTerm($term);
		$data = Classes::with(
			array(
				'class_meeting' => function($query) use ($term_code) {
					$query->where('sterm', $term_code);
				}, 
				'class_instructors' => function($query) use ($term_code) {
					$query->where('sterm', $term_code);
				}
			)
		)->where('sterm', $term_code);

		$data = $data->get()->toArray();
		$this->prepareClassesResponse($data);

		if(Input::has('instructor')){
			$this->filterClassesByInstructor(Input::get('instructor'), $data);
		}

		$response = array(
			'success'	  => true,
			'data'	      => $data,
			'status'      => 200
		);

		return Response::make($response, 200);

	}

	/**
	 * Get class information for a specific class if a ticket number is given,
	 *	or class information for all classes with a specific subject and
	 *	catalog_number if subject-catalog_number is given, all for the given term
	 * @todo Exceptions in else block, and is_numeric check on ticket number
	 * @link /term/{term}/classes/{id} 	GET
	 * @param string $term, int|string $id
	 * @return class info for ticket number|subject-catalog_number for the given term
	 *
	 */
	public function show($term, $id)
	{
		$term_code = $this->generateTermCodeFromSemesterTerm($term);
		$data = Classes::with(
			array(
				'class_meeting' => function($query) use ($term_code) {
					$query->where('sterm', $term_code);
				}, 
				'class_instructors' => function($query) use ($term_code) {
					$query->where('sterm', $term_code);
				}
			)
		)->where('sterm', $term_code);


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

		$data = $data->get()->toArray();
		$this->prepareClassesResponse($data);

		$response = array(
			'success'	  => true,
			'data'	      => $data,
			'status'      => 200
		);

		return Response::make($response, 200);

	}

}