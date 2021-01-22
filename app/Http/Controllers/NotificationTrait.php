<?php
namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
trait NotificationTrait{

    // used you tried to access any element not found in database
    public static function NotFound($title='Attention',$message='This Element Not Found'){
//        Alert::error($title,$message);
        toast($message,'error');
    }

    // if you tried to perform any operation and done successfully
    public static function Success($title='Success',$message='Successful Operation'){
//        Alert::success($title,$message);
        toast($message,'success');
    }

    // if you tried to perform any operation and failed
    public static function Fail($title='Fail',$message='Failed Operation'){
//        Alert::error($title,$message);
        toast($message,'error');
    }

    // if you tried to Access Some Content Or Do Some Operation You Dont Allowed To Access
    public static function NotAuthorized($title='Sorry',$message='Not Allowed To You To Access This Content'){
//        Alert::error($title,$message);
        toast($message,'error');
    }
}
