<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (\Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, \Throwable $e)
    {
        if ($request->is('api/*')) {
            $status = 500;
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                $status = $e->getStatusCode();
            } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
                $status = 401;
            }
            
            if ($e instanceof \Laravel\Passport\Exceptions\OAuthServerException) {
                \Illuminate\Support\Facades\Log::error('Passport OAuth Error:', [
                    'Message' => $e->getMessage(),
                    'Hint' => $e->getHint(),
                    'Auth' => $request->header('Authorization')
                ]);
            }

            \Illuminate\Support\Facades\Log::error('API Error:', [
                'Status' => $status,
                'Message' => $e->getMessage(),
                'Auth' => $request->header('Authorization'),
                'Exception' => get_class($e)
            ]);
            return response()->json([
                'response' => [
                    'statuscode' => $status,
                    'message' => ($status == 401) ? 'Unauthenticated or Invalid Token' : ($e->getMessage() ?: 'Something went wrong'),
                    'error' => true
                ]
            ], $status);
        }

        return parent::render($request, $e);
    }
}
