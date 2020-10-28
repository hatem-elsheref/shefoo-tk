<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index(){
        return view('backend.home.index');
    }
}
