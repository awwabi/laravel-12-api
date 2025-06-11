<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Disable redirects for API routes.
     */
    protected function redirectTo($request): ?string
    {
        return $request->expectsJson() || $request->is('api/*') ? null : route('login');
    }
}
