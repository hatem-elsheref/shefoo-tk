<?php

  // prepare the new full name of the uploaded file for user/admin/etc.. 

if(!function_exists('preparePathToUpload')){
    function preparePathToUpload($request,$folderName){
        $name=time().'-'.Str::slug($request->name).'-image.'.$request->file('image')->getClientOriginalExtension();
        return mainPath($folderName.'/'.$name);
    }
}
