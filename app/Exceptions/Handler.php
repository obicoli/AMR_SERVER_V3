<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $userLevelCheck = $exception instanceof \jeremykenedy\LaravelRoles\Exceptions\RoleDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\Exceptions\RoleDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\Exceptions\PermissionDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\Exceptions\LevelDeniedException;
        $errors_code = Config::get('response.http');
        if ($userLevelCheck) {
            if ($request->expectsJson()) {
                return response()->json($errors_code['403'],403);
            }
            abort(403);
        }

        $status_code = $this->getExceptionHTTPStatusCode($exception);
        $stat_ = ''.$status_code.'';
        return response()->json($errors_code[$stat_],$status_code);

    }

    protected function getExceptionHTTPStatusCode($e){
        // return method_exists($e, 'getStatusCode') ?
        //     $e->getStatusCode() : 500;
        return method_exists($e, 'getStatusCode') ?
            $e->getStatusCode() : 500;
    }
}
