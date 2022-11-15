<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
        
        // check if the request is an api request
        if(empty($request->header('Authorization'))){
            header('HTTP/1.0 401');
            echo 'Unauthorization';
            die();
        }

        //if(empty($request->header('Authorization'))){ : melakukan pengeceakan apakah ada header bernama key Authorization ada ketika melakukan request api jika tidak ada maka dinyatakan Unauthorization
    }
}
