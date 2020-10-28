<?php


if (!function_exists('backendAssets')){
    function backendAssets($asset){
        return asset('assets/backend/'.$asset);
    }
}


if (!function_exists('frontendAssets')){
    function frontendAssets($asset){
        return asset('assets/frontend/'.$asset);
    }
}
