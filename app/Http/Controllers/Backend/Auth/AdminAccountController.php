<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
class AdminAccountController extends Controller
{



    //return the current authenticated admin view
    public function showAccount(){
        return view('backend.auth.account');
    }

    // method that update the normal information of the current authenticated admin
    public function updateInformation(Request $request){
        // to active and show the information tab in frontend
        $request->tab='information';
        // store the current authenticated admin in the backend/admin guard in var
        $admin=auth(ADMIN_GUARD)->user();
        // make some validation to inputs
       $request->validate([
           'name'    =>['required','string','max:191'],
           'email'   =>['required','string','max:191',Rule::unique('admins')->ignore($admin->id)],
           'image'   =>['image','mimes:jpg,jpeg,png,webp','max:'.ADMIN_AVATAR_MAX_SIZE]
       ]);
       // check if inputs has image already uploaded by the authenticated admin
       if($request->hasFile('image') && !empty($request->file('image'))){
           // get the prepared path
           $path=preparePathToUpload($request,_ADMIN);
          // upload the file with some configuration
           Image::make($request->file('image'))->resize(260, 260)->save($path,100);

          // check if the old file already exists or not to remove it if exist
           if($admin->avatar != mainPath(_ADMIN.'/'.DEFAULT_AVATAR)){
               if(File::exists(fullPath($admin->avatar))){
                  File::delete(fullPath($admin->avatar));
               }        
           }
       }else{
           // if no uploaded file take the old file
           $path=$admin->avatar;
       }
       // prepare the new validated data
       $validatedData=$request->except(['_method','_token','image','tab']);
       $validatedData['avatar']=$path;
    
       
       // check if update done or not
       if($admin->update($validatedData)){
        self::Success();
        auth(ADMIN_GUARD)->loginUsingId($admin->id);
       }else
           self::Fail();
       
       
       return redirect()->route('dashboard.account.show');

    }

    // method to reset the admin password
    public function resetPassword(Request $request){
       // to active and show the security tab in frontend
        $request->tab='security';
        // make some validation to inputs
        $request->validate([
            'old_password' =>['required','string','min:'.ADMIN_PASSWORD_LENGTH],
            'new_password' =>['required','string','min:'.ADMIN_PASSWORD_LENGTH,'required_with:password_confirmation','same:password_confirmation']
        ]);
        $admin=auth(ADMIN_GUARD)->user();
        // check if the old password that the admin entered equal the current password
        if(Hash::check($request->old_password, $admin->password)){
            //  valid old password
            $admin->password=Hash::make($request->new_password);
            $admin->save();
            // login after save the new password
            auth(ADMIN_GUARD)->loginUsingId($admin->id);
            self::Success();
            return redirect()->route('dashboard.account.show');
        }else{
            // invalid old password
            self::Fail('Error','Invalid Old Password');
            return redirect()->route('dashboard.account.show')->withInput();
        }
    
        
    }

  

}