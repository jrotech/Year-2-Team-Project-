<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs to exclude from CSRF protection
     */
    //JUST FOR ARTILLERY TEST,  REMEMBER TO REMOVE
    protected $except = [
        '/login',
        '/basket/add/*',
        '/api/checkout',
    ];
}
