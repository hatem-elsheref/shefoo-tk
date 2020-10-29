<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\NotificationTrait;
use App\Http\Middleware\BackendAuthentication;


class BackendAuthentication
{
    use NotificationTrait;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
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
            // this url required the admin not to be authenticated
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
      return true   if he/she is a guest
      return false  if he/she is a authenticated
      */
    private function checkIfTheAdminIsAuthenticated($guard){
        if (\Auth::guard($guard)->check()){
            return true;
        }
        return  false;
    }


    /* check if there is not an authentication in the provided guard
      the current admin or user is guest (not login)
      return true   if he/she is a guest
      return false  if he/she is a authenticated
      */
    private function checkIfTheAdminIsGuest($guard){
        if ( \Auth::guard($guard)->check()){
            return false;
        }
        return true;
    }
}
