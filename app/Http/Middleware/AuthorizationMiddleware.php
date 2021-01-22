<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\NotificationTrait;

class AuthorizationMiddleware
{
    use NotificationTrait;

    /**
     * @param $request
     * @param Closure $next
     * @param $permission
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next,$permission)
    {

        if(haveThePermission($permission))
            return $next($request);

        //else

        self::NotAuthorized();
        return redirect()->route('dashboard.index');


    }
}
