<?php

namespace App\Exceptions;

use App\Handlers\HandlerUtilities;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        ModelNotFoundException::class,
        NotFoundHttpException::class,
        ValidationException::class
    ];

    /**
     * Repor t or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
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
        if($e instanceof NotFoundHttpException) {
        $response = [
            'errors' => ['Resource could not be resolved']
        ];
        return HandlerUtilities::sendErrorResponse($response, 404, $request);
        } else if ($e instanceof ModelNotFoundException) {
                $response = [
                    'errors' => ['Resource could not be found.']
                ];
                return HandlerUttilities::sendErrorResponse($response, 503, $request);
            }
        }
}
