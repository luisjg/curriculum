<?php namespace Curriculum\Http\Controllers;

use Auth,
	Request,
	Validator;

use Illuminate\Support\Collection;

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
		$course = Course::create(array_only($input, array_keys($rules)));
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

	/**
	 * Handles the display of the Search Courses page.
	 * GET /admin/courses/search
	 *
	 * @return View
	 */
	public function getSearch() {
		return view('pages.admin.courses.search');
	}

	/**
	 * Handles the submission from the Search Courses page. Returns the
	 * results as JSON.
	 * POST /admin/courses/search
	 *
	 * @return JSON
	 */
	public function postSearch() {
		$query = trim(Request::input('query'));
		if(empty($query)) return "{}";

		// figure out the possible format of the query
		$tokens = explode(" ", $query);
		$subjCourses = new Collection();

		// one/two token(s) could also mean "give me everything with this subject"
		// or "give me everything with this catalog number" so this will be
		// regarded as extra course information
		if(count($tokens) == 1 || count($tokens) == 2) {
			$subjCourses = Course::where('subject', implode(" ", $tokens))
				->orWhere('catalog_number', $tokens[0])
				->orderBy('subject')->orderBy('catalog_number')
				->get();
		}

		if(count($tokens) == 2 && preg_match("/[0-9]+/", $tokens[1])) {
			// could be catalog designation if the second token has a number in it
			$courses = Course::where('subject', $tokens[0])->where('catalog_number', $tokens[1]);
		}
		else
		{
			// catalog designation using two letters with a space in-between
			if(count($tokens) == 3
				&& strlen($tokens[0]) < 3
				&& strlen($tokens[1]) < 3
				&& preg_match("/[0-9]+/", $tokens[2])) {
					$courses = Course::where('subject', "{$tokens[0]} {$tokens[1]}")
						->where('catalog_number', $tokens[2]);
			}
			else
			{
				// narrow the search down by course title instead
				$courses = Course::where('title', 'LIKE', "%" . array_shift($tokens) . "%");
				foreach($tokens as $token) {
					$courses = $courses->where('title', 'LIKE', "%{$token}%");
				}
			}
		}

		// grab the results
		$results = $courses->orderBy('subject')->orderBy('catalog_number')->get();

		// if there is extra stuff, merge it with the results
		if(!$subjCourses->isEmpty()) {
			$results = $subjCourses->merge($results);
		}

		// return everything as JSON
		return $results->toJSON();
	}
}