<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\NotificationTrait;
use Illuminate\Support\Facades\Auth;

class BackendAuthentication
{
    use NotificationTrait;

    /**
     * @param $request
     * @param Closure $next
     * @param string $guard
     * @param string $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next,$guard='backend',$type ='auth')
    {
        // this url required the admin to be authenticated
        if ($type === 'auth'){
            if ($this->checkIfTheAdminIsAuthenticated($guard))
                return $next($request);
            else{
                self::NotAuthorized();
                return redirect()->route('dashboard.login.show');
            }
        }else{
            // this url required the admin  [ not ] to be authenticated
            if ($this->checkIfTheAdminIsGuest($guard))
                return $next($request);
            else{
                self::NotAuthorized();
                return redirect(RouteServiceProvider::BACKEND);
            }

        }
    }

     /* check if there is not an authentication in the provided guard
      the current admin or user is guest (not login)
      return true   if user is a guest
      return false  if user is a authenticated
      */
    private function checkIfTheAdminIsAuthenticated($guard){
        return Auth::guard($guard)->check() ? true : false;
    }


    /* check if there is not an authentication in the provided guard
      the current admin or user is guest (not login)
      return true   if the user is a guest
      return false  if the user is a authenticated
      */
    private function checkIfTheAdminIsGuest($guard){
        return Auth::guard($guard)->check() ? false : true;
    }
}
