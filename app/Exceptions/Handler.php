<?php

namespace App\Exceptions;

use App\Services\SlackErrorHandler;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use PhpParser\Builder\Method;
use App\Services\LoggerFactory;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     * Subclasses of these exceptions should not be reported either
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        // Check if the exception is a subclass or class included in $this->dontReport
        $dontReport = collect($this->dontReport)->filter(
            function ($value) use ($e) {
                return is_a($e, $value);
            }
        );
        if (!$dontReport->count()) {
            $slack = new SlackErrorHandler();
            $slack->sendApiException($e);
        }
        $logFactory = new LoggerFactory;
        $log = $logFactory->setPath('logs/api')->createLogger('error_log');
        $log->error('Request Error: '. $e->getMessage());
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json(
                [
                'errors' => [
                'detail' => [],
                'message' => 'No resource with that model name found.'
                ],
                'data' => null,
                'status' => 404
                ], 404
            );
        }

        return parent::render($request, $e);
    }
}
