<?php

namespace App\Http\Controllers\Backend\Setting;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    public function index(){
        return view('backend.setting.settings-overview');
    }
}
