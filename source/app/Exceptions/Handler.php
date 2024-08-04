<?php

namespace App\Exceptions;

use App\Models\LoggingData;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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

        });

        $this->renderable(function (Throwable $e, Request $request) {
            if ($e instanceOf NotFoundHttpException) {
                return response()->notFound();
            }
            $log = new LoggingData();
            if (isset(Auth::user()->id))
            {
                $log->user_id = Auth::user()->id;
            }
            else
            {
                $log->user_id = null;
            }
            $log->action = $request->fullUrl();
            $log->method = $request->method();
            $log->exception = $e->getMessage();
            $log->save();
        });
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->unauthorized();
    }
}
