<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Exceptions\UserNotAuthorized;
use App\Models\ApiClients;

class APIClientAuthenticate
{

    public function handle($request, Closure $next)  
    {  

        $token = $request->header('CLIENT_TOKEN');

        if(!$token) {  

            throw new UserNotAuthorized('UnAuthorized Request! CLIENT TOKEN is missing.');  
        }
        
        $client = ApiClients::where('token', '=', $token)->first();
        if(!$client){  

            throw new UserNotAuthorized('UnAuthorized client token');  
        }  
        Session::flash('client', $client);
        return $next($request);  
    }
}
