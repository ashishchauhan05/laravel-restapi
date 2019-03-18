<?php

namespace App\Exceptions;

use Exception;

abstract class ApiException extends Exception
{
    const BAD_REQUEST = 'bad_request';

    const FORBIDDEN = 'forbidden';

    const NOT_FOUND = 'not_found';

    const PRECONDITION_FAILED = 'precondition_failed';

    protected $id;

    protected $status;

    protected $title;

    protected $detail;

    protected $errors;

    public function __construct($message, $status = 500, $errors = [])
    {
        $this->status = $status;
        $this->errors = $errors;

        parent::__construct($message);
    }

    public function getStatus()
    {
        return $this->getStatusCode();
    }

    public function getStatusCode()
    {
        return (int) $this->status;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function toArray()
    {
        return[
            'id' => $this->id,
            'status' => $this->status,
            'title' => $this->title,
            'detail' => $this->detail,
            'errors' => $this->errors
        ];
    }

    protected function build(array $args)
    {
        $this->id = array_shift($args);

        $error = config(sprintf('errors.%s', $this->id));

        $this->title = $error['title'];
        $this->detail = vsprintf($error['detail'], $args);

        return $this->detail;
    }
}
