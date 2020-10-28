<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    const GUARD='backend';
    const BLOCKED='blocked';
    public function showLoginForm(){
        return view('backend.auth.login');
    }

    public function login(Request $request){
        // validate email and password before make the login process
        $request->validate([
            'email'     =>'required|string|email|exists:admins,email',
            'password'  =>'required|string|min:'.ADMIN_PASSWORD_LENGTH
        ]);
        $credentials=['email'=>$request->email,'password'=>$request->password];
        $rememberMe=$request->has('rememberMe');
        // try to login with the above credentials
        if (Auth::guard(self::GUARD)->attempt($credentials,$rememberMe)){
            // login done
            $authenticatedAdmin=Auth::guard(self::GUARD);
            // check if the authenticated user is blocked by super admin or not
            if ($authenticatedAdmin->user()->status === self::BLOCKED){
                // the authenticated user is blocked
                // logout and return back with messages and inputs
                $authenticatedAdmin->logout();
                return redirect()->route('dashboard.login.show')->withInput()
                    ->withErrors('email_or_password','Your Account Is Blocked Call Back The Admin To Solve The Problem');
            }else{
                // the authenticated user is not blocked
                // get the permissions of the authenticated user role and put it in session and redirect to dashboard
                $currentAuthenticatedAdminPermission=$authenticatedAdmin->user()->adminGroup->permissions->pluck('name')->toArray();
                session()->put('permissions',$currentAuthenticatedAdminPermission);
                return redirect()->route('dashboard.index');
            }
        }else{
            // login failed
            // return back with the inputs and error message
            return redirect()->route('dashboard.login.show')->withInput()
         ->withErrors('email_or_password','Invalid Email Or Password');
        }
    }

    public function logout(){
        Auth::guard(self::GUARD)->logout();
        return redirect()->route('dashboard.login.show');
    }

}
