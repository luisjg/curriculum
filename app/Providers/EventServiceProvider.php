<?php namespace Curriculum\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Curriculum\Models\Course,
	Curriculum\Models\User;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'event.name' => [
			'EventListener',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		// register a custom event handler for a Course
		Course::creating(function($course) {
			// generate the courses_id for the course
			$course->courses_id = 'courses:' . $course->course_id;
		});

		// register a custom event handler for a User to handle assignment
		// of default roles upon creation
		User::created(function($user) {
			
		});
	}

}
