<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;

class BackendAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard='backend',$type ='auth')
    {
        if ($type === 'auth'){
            if ($this->checkIfTheAdminIsAuthenticated($guard))
                return $next($request);
            else
                return redirect()->route('dashboard.login.show');

        }else{
            if ($this->checkIfTheAdminIsGuest($guard))
                return $next($request);
            else
                return redirect(RouteServiceProvider::BACKEND);

        }
    }


    private function checkIfTheAdminIsAuthenticated($guard){
        if (\Auth::guard($guard)->check()){
            return true;
        }
        return  false;
    }

    private function checkIfTheAdminIsGuest($guard){
        if ( \Auth::guard($guard)->check()){
            return false;
        }
        return true;
    }
}
