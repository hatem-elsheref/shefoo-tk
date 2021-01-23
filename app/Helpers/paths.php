<?php

// return the full path or url of backend assets
if (!function_exists('backendAssets')){
    function backendAssets($asset){
        return asset('assets/backend/'.$asset);
    }
}

// return the full path or url of frontend assets
if (!function_exists('frontendAssets')){
    function frontendAssets($asset){
        return asset('assets/frontend/'.$asset);
    }
}

// return the full path or url of uploaded files
if (!function_exists('uploads')){
    function uploads($file){
        return asset($file);
    }
}

// return the name of the main folder of uploaded files used in url from public folder
if (!function_exists('mainPath')){
    function mainPath($file){
        return 'uploads/'.$file;
    }
}

// return the full path of the given file  used in file system
if (!function_exists('fullPath')){
    function fullPath($file){
        return base_path('public/'.$file);
    }
}
