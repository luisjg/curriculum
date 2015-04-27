<?php namespace Curriculum\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Curriculum\Handlers\HandlerUtilities;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if($e instanceof PermissionDeniedException) {
			return response(view('pages.errors.401', compact('e')), 401);
		}
		else if($e instanceof NotFoundHttpException) {
			// handle API 404 errors differently
			if(starts_with($request->path(), 'api/')) {
				$response = [
					'status'      => 404,
					'success'	  => false,
					'type'		  => 'errors',
					'errors'	  => ['Resource could not be resolved']
				];
				return HandlerUtilities::sendResponse($response);
			}

			// front-end 404 errors get the 404 page
			return response(view('pages.errors.404'), 404);
		}
		else if($e instanceof ModelNotFoundException) {
			return response(view('pages.errors.404'), 404);
		}

		return parent::render($request, $e);
	}

}
