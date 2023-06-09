<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\InvalidCredentialsError;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Common\Error\UnauthorizedError;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
	    if($exception instanceof NotFoundError){
		return response()->json(['error' => $exception->message], 404);
	    }

	    if($exception instanceof ForbiddenError){
		return response()->json(['error' => $exception->message], 403);
	    }

	    if($exception instanceof InvalidCredentialsError || $exception instanceof UnauthorizedError){
		return response()->json(['error' => $exception->message], 401);
	    }

	    return parent::render($request, $exception);
    }
}
