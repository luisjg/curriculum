<?php namespace Curriculum\Http\Controllers;

use Auth,
	Request,
	Validator;

use Curriculum\Exceptions\PermissionDeniedException;
use Curriculum\Models\Course,
	Curriculum\Models\Subject,
	Curriculum\Models\Term;

class AdminCourseController extends Controller {

	/**
	 * Constructs a new AdminCourseController object.
	 */
	public function __construct() {
		parent::__construct();

		// ensure the controller makes use of authentication functionality
		$this->middleware('auth');
	}

	/**
	 * Handles the display of all courses.
	 * GET /admin/courses
	 *
	 * @return View
	 */
	public function index() {
		// perform permission check
		if(!Auth::user()->hasPerm('course.retrieve.all')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		// grab a set of paginated courses and set the pagination URL
		$courses = Course::orderBy('subject')
			->orderBy('catalog_number')
			->paginate(25);
		$courses->setPath(url('/admin/courses'));

		return view('pages.admin.courses.index', compact('courses'));
	}

	/**
	 * Handles the display of the Create Course screen.
	 * GET /admin/courses/create
	 *
	 * @return View
	 */
	public function create() {
		// perform permission check
		if(!Auth::user()->hasPerm('course.create')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		// grab the subjects so we have something for the drop-down on the view
		$subjects = Subject::all()->lists('name', 'subject');
		return view('pages.admin.courses.create', compact('subjects'));
	}

	/**
	 * Handles the submission from the Create Course screen.
	 * POST /admin/courses
	 *
	 * @return Response
	 */
	public function store() {
		// perform permission check
		if(!Auth::user()->hasPerm('course.create')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		// validate the input
		$validator = Validator::make(
			$input = [
				'course_id'			=> Request::input('course_id'),
				'title'				=> strtoupper(Request::input('title')),
				'subject'			=> Request::input('subject'),
				'catalog_number'	=> Request::input('catalog_number'),
			],
			$rules = [
				'course_id'			=> 'required|numeric|unique:omar.courses,course_id',
				'title'				=> 'required|max:255',
				'subject'			=> 'required|exists:omar.subjects,subject',
				'catalog_number'	=> 'required|alpha_num',
			]
		);

		// if the validator fails kick them back
		if($validator->fails()) {
			return redirect()->back()->withInput()->withErrors($validator);
		}

		// ensure the course does not already exist before proceeding
		$courseTest = Course::whereSubjectCatalog(
			$input['subject'], $input['catalog_number']
		)->first();
		if($courseTest != null) {
			return redirect()->back()->withInput()->withErrors([
				'exists' => 'A course with that subject and catalog number already exists.'
			]);
		}

		// create the new course
		$course = new Course();
		$course->fill(array_only($input, array_keys($rules)));
		$course->courses_id = 'courses:' . str_pad($course->course_id, 6, '0', STR_PAD_LEFT);
		$course->save();
		$course->touch();

		// redirect with a success message
		$success = "You have successfully created a new course (" . e($input['subject'])
			. " " . $input['catalog_number']  . ": " . e($input['title']) . ").";
		return redirect(route('admin.courses.index'))->with('success', $success);
	}

	/**
	 * Handles the display of the Modify Course screen.
	 * GET /admin/courses/{id}/edit
	 *
	 * @param integer $id The ID of the course to modify
	 * @return View
	 */
	public function edit($id) {
		// perform permission check
		if(!Auth::user()->hasPerm('course.modify')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		// grab the course
		$course = Course::findOrFailByCourseId($id);

		// grab the subjects so we have something for the drop-down on the view
		$subjects = Subject::all()->lists('name', 'subject');
		return view('pages.admin.courses.edit', compact('course', 'subjects'));
	}

	/**
	 * Handles the submission from the Modify Course screen.
	 * PUT /admin/courses/{id}
	 *
	 * @param integer $id The ID of the course to modify
	 * @return Response
	 */
	public function update($id) {
		// perform permission check
		if(!Auth::user()->hasPerm('course.modify')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		// grab the course
		$course = Course::findOrFailByCourseId($id);

		// validate the input
		$validator = Validator::make(
			$input = [
				'title'				=> strtoupper(Request::input('title')),
				'subject'			=> Request::input('subject'),
				'catalog_number'	=> Request::input('catalog_number'),
			],
			$rules = [
				'title'				=> 'required|max:255',
				'subject'			=> 'required|exists:omar.subjects,subject',
				'catalog_number'	=> 'required|alpha_num',
			]
		);

		// if the validator fails kick them back
		if($validator->fails()) {
			return redirect()->back()->withInput()->withErrors($validator);
		}

		// ensure the course does not already exist before proceeding; this check
		// only takes place if either the subject or the catalog number has been
		// modified
		if($course->subject != $input['subject'] ||
			$course->catalog_number != $input['catalog_number'])
		{
			$courseTest = Course::whereSubjectCatalog(
				$input['subject'], $input['catalog_number']
			)->first();
			if($courseTest != null) {
				return redirect()->back()->withInput()->withErrors([
					'exists' => 'A course with that subject and catalog number already exists.'
				]);
			}
		}

		// save the course
		$course->fill(array_only($input, array_keys($rules)));
		$course->save();
		$course->touch();

		// redirect with a success message
		$success = "You have successfully updated a course (" . e($input['subject'])
			. " " . $input['catalog_number']  . ": " . e($input['title']) . ").";
		return redirect(route('admin.courses.show', ['id' => $course->course_id]))
			->with('success', $success);
	}

	/**
	 * Handles the display of a single course.
	 * GET /admin/courses/{id}
	 *
	 * @param integer $id The ID of the course to display
	 * @return View
	 */
	public function show($id) {
		// perform permission check
		if(!Auth::user()->hasPerm('course.retrieve')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		// grab the course
		$course = Course::findOrFailByCourseId($id);
		return view('pages.admin.courses.show', compact('course'));
	}
}