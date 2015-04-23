<?php namespace Curriculum\Http\Controllers;

use Auth,
	Request;

use Curriculum\Exceptions\PermissionDeniedException;
use Curriculum\Handlers\HandlerPagination;
use Curriculum\Models\Classes,
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
		$courses = Classes::groupAsCourse(Term::current()->term_id, 'true')
			->paginate(25);
		$courses->setPath('courses');

		return view('pages.admin.courses.index', compact('courses', 'paginator'));
	}
}