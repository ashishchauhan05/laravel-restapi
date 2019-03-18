<?php

namespace App\Exceptions;

class ApiGenericException extends ApiException
{
    public function __construct($message, $status = 500, $errors = [])
    {
        parent::__construct($message, $status, $errors);
    }
}
