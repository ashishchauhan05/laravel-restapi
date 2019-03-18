<?php

// Defining the response codes for HTTP Methods
// [success, failure]
return [
    'get' => ['success' => 200, 'failure' => 400],

    'post' => ['success' => 201, 'failure' => 400],

    'put' => ['success' => 201, 'failure' => 400],

    'patch' => ['success' => 201, 'failure' => 400],

    'delete' => ['success' => 202, 'failure' => 400],

    'error' => 500,

    'missing_content' => ['code' => 400],
    
    'resource_not_found' => ['code' => 404, 'message' => 'resource not found'],
];