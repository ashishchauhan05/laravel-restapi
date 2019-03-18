<?php

namespace App\Exceptions;

class UserNotAuthorized extends ApiException
{

    protected $status = 401;
    // provided extra functionality that you may need in here.
    public function __construct($message, array $detail = [])
    {
        parent::__construct($message, $this->status, $detail);
    }
}
