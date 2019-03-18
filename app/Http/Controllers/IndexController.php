<?php namespace App\Http\Controllers;

use Auth;

class IndexController extends Controller {

    /**
     * Initializer.
     *
     * @return \AdminController
     */
    public function __construct()
    {
        // parent::__construct();
        // $this->middleware('auth');
        // $this->middleware('admin');
    }

    public function index() {
        return [
            'message' => "API Index"
        ];
    }

}
