<?php

namespace App\Http\Controllers\API;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\ApiGenericException;


class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * All offers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return array(
            'API index page'
        )
    }
}
