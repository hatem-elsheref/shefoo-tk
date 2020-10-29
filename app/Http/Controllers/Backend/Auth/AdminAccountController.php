<?php


namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AdminAccountController extends Controller
{
    public function showAccount(){
        return view('backend.auth.account');
    }

    public function updateInformation(Request $request){
        $admin=auth('backend')->user();
       $request->validate([
           'name'    =>['required','string','max:191'],
           'email'   =>['required','string','max:191',Rule::unique('admins')->ignore($admin->id)],
           'avatar'  =>['image','mimes:jpg,jpeg,png,webp','max:2000']
       ]);

       if($request->hasFile('avatar') && !empty($request->file('avatar'))){
           $name=time().'-'.Str::slug($request->name).'-avatar.'.$request->file('avatar')->getClientOriginalExtension();
           $path=$this->preparePathToUpload($name);
           Image::make($request->file('avatar'))->resize(260, 260)->save($path);

          
           if($admin->avatar != 'uploads/admins/default-user.png'){
        
              Storage::disk('uploads')->delete(public_path($admin->avatar));
           }
       }else{
           $path=$admin->avatar;
       }
       $status=$admin->update([
           'name'   =>$request->name,
           'email'  =>$request->email,
           'avatar' =>$path
       ]);
       if($status){
           self::Success();
       }else{
           self::Fail();
       }
       return redirect()->route('dashboard.account.show');

    }

    public function resetPassword(){

    }
    private function preparePathToUpload($image){
        return 'uploads/admins/'.$image;
    }

}
