<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\NotificationTrait;

class AuthorizationMiddleware
{
    use NotificationTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
    
        if(haveThePermission($permission)){
            return $next($request);
        }

        self::NotAuthorized();
        return redirect()->route('dashboard.index');

    
    }
}
