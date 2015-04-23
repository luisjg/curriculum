<?php namespace Curriculum\Http\Controllers;

use Auth,
	Request;

use Curriculum\Exceptions\PermissionDeniedException;
use Curriculum\Models\Course,
	Curriculum\Models\Term;

class AdminCourseController extends Controller {

	/**
	 * Constructs a new AdminCourseController object.
	 */
	public function __construct() {
		parent::__construct();

		// ensure the route makes use of authentication functionality
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

		// grab a set of paginated courses; if the second parameter was set
		// to 'false', the courses would just be from the current term instead
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

	}

	/**
	 * Handles the submission from the Create Course screen.
	 * POST /admin/courses
	 *
	 * @return Response
	 */
	public function store() {

	}

	/**
	 * Handles the display of the Modify Course screen.
	 * GET /admin/courses/{id}/edit
	 *
	 * @param integer $id The ID of the course to modify
	 * @return View
	 */
	public function edit($id) {

	}

	/**
	 * Handles the submission from the Modify Course screen.
	 * PUT /admin/courses/{id}
	 *
	 * @return Response
	 */
	public function update($id) {

	}
}