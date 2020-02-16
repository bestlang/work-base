<?php

namespace App\Exceptions;

use Exception;
use function GuzzleHttp\Psr7\str;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $statusCode = 200;
        $errMessage = '';
        if($e instanceof HttpExceptionInterface){
            $statusCode = $e->getStatusCode();
        }else if($e instanceof ValidationException){
            $statusCode = $e->status;
            $errMessage = $e->errors();
        }else if($e instanceof Exception){
            $statusCode = $e->getCode();
            $errMessage = $e->getMessage();
        }
        if($request->expectsJson()){
            return response()->error($errMessage, $statusCode);
        }else{
            return parent::render($request, $e);
        }
    }
}
