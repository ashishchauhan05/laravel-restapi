<?php

namespace App\Exceptions;

class NotFoundException extends ApiException
{
    protected $status = 404;

    public function __construct($message, array $detail = [])
    {
        parent::__construct($message, $this->status, $detail);
    }
}
