<?php

namespace App\Services;

use Exception;
use Slack;
use View;
use Carbon\Carbon;

use App\Models\WebError;

/**
 * Handles logging errors to a slack channel
 * Should be general enough to handle logging API and Web errors
 */
class SlackErrorHandler
{

    protected function getCurrentDateTime()
    {
        return Carbon::now()->format('g:i:s A, F j, Y');
    }

    public function sendApiException(Exception $exception)
    {
        // Allow not using this service by setting SLACK_WEBHOOK_URL=false in the .env
        if (!config('slack.endpoint')) {
            return false;
        }

        $message = View::make(
            'exceptions.api-error-message', [
            'exception' => $exception,
            'previous_exception' => $exception->getPrevious(),
            'datetime' => $this->getCurrentDateTime(),
            'developer' => config('slack.developer'),
            'environment' => config('app.env')
            ]
        )->render();

        Slack::send($message);
    }
}
