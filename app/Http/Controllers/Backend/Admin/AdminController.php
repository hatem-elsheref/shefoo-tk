<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Admin;
use App\Models\Group;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminController extends Controller{


    private $administrationGroup;

    public function __construct(){
        $this->administrationGroup= Group::where('name',config('trusting.administratorGroup')['name'])->value('id');
    
        $this->middleware('authorized:read_admin')->only('index');
        $this->middleware('authorized:create_admin')->only(['create','store']);
        $this->middleware('authorized:update_admin')->only(['edit','update']);
        $this->middleware('authorized:delete_admin')->only(['destroy']);
   
    }

    // return view that show all admins in table
    public function index(){
        $admins=Admin::with('adminGroup')->where('group','!=',$this->administrationGroup)->orderByDesc('id')->get();
        return view('backend.admin.index',compact('admins'));
    }

    // return the view of create new admin
    public function create(){
        // get all system groups except the administration group (the main group of the owner ) 
        $groups=Group::select('display_name','id')->where('id','!=',$this->administrationGroup)->get();
        return view('backend.admin.create',compact('groups'));
    }

    //store the new admin data and make validation with the admin request
    public function store(AdminRequest $request){

        // check if the request has file
       $validatedData=$request->except(['_method','_token','status','image','group','password']);

       if($request->hasFile('image')){
            // prepare the new file path and name
            $path=preparePathToUpload($request,_ADMIN);
            // upload the file with some configuration
            Image::make($request->file('image'))->resize(260, 260)->save($path,100);
        }else{
            // no image uploaded so that take the default image
           $path=mainPath(_ADMIN.'/'.DEFAULT_AVATAR);
        }
        $validatedData['avatar']=$path;

        // check if the new admin blocked or not
        if ($request->has('status') and !empty($request->status)) {
            $validatedData['status']='blocked';
        }else{
            $validatedData['status']='non-blocked';
        }


        // check or sure the given group not the super admin (administration) group
        if($this->administrationGroup != $request->group){
            $validatedData['group']=$request->group;
        }else{
            self::Fail('Attention','Not Allowed Group');
            return redirect()->route('Admin.create')->withInput();
        }

        $validatedData['password']=Hash::make($request->password);
        $admin=Admin::create($validatedData);
        if($admin){
            self::Success();
        }else{
            self::Fail();
        }

        return redirect()->route('Admin.index');
    }


    public function edit($admin){
        // check if the given admin id is already exist
 
        $admin=Admin::with(['adminGroup'=>function($query){
            $query->select('id','display_name');
        }])->find($admin);

        if($this->checkIfTheGivenAdminNotExist($admin)){
            return redirect()->route('Admin.index');
        }
        // if the admin is administrator cancel the operation
        if(!$this->checkIfAllowedToDeleteOrUpdate($admin)){
            self::NotAuthorized();
            return redirect()->route('Admin.index');
        }
        // get all system groups except the administration group (the main group of the owner ) 
        $groups=Group::select('display_name','id')->where('id','!=',$this->administrationGroup)->get();
        return view('backend.admin.edit',compact('groups'))->withAdmin($admin);
    }

    public function update(AdminRequest $request,$admin){



        $admin=Admin::find($admin);

        // check if the given admin already exists in database
        if($this->checkIfTheGivenAdminNotExist($admin)){
            return redirect()->route('Admin.index');
        }

         // if the admin is administrator cancel the operation
        if(!$this->checkIfAllowedToDeleteOrUpdate($admin)){
            self::NotAuthorized();
            return redirect()->route('Admin.index');
        }


        // check if the request has file
       $validatedData=$request->except(['_method','_token','status','image','group','password']);

       if($request->hasFile('image')){
            // prepare the new file path and name
            $path=preparePathToUpload($request,_ADMIN);
            // upload the file with some configuration
            Image::make($request->file('image'))->resize(260, 260)->save($path,100);
            // if the image is the default not remove it
            if($admin->avatar !== mainPath(_ADMIN.'/'.DEFAULT_AVATAR)){
                // check the file already exists in hdd
                if(File::exists(fullPath($admin->avatar))){
                    File::delete(fullPath($admin->avatar));
                 }   
            }
                 
        }else{
            // no image uploaded so that take the old image
           $path=$admin->avatar;
        }
        $validatedData['avatar']=$path;

        // check if the new admin blocked or not
        if ($request->has('status') and !empty($request->status)) {
            $validatedData['status']='blocked';
        }else{
            $validatedData['status']='non-blocked';
        }


        // check or sure the given group not the super admin (administration) group
        if($this->administrationGroup != $request->group){
            $validatedData['group']=$request->group;
        }else{
            self::Fail('Attention','Not Allowed Group');
            return redirect()->route('Admin.create')->withInput();
        }


        //check if the the admin enter password or not

        if($request->has('password') && !empty($request->password)){
            $validatedData['password']=Hash::make($request->password);
        }else{
            $validatedData['password']=$admin->password;
        }
       
        
        if($admin->update($validatedData)){
            self::Success();
        }else{
            self::Fail();
        }

        return redirect()->route('Admin.index');
    }
    public function destroy($admin){
        
        $admin=Admin::find($admin);

        // check if the given admin already exists in database
        if($this->checkIfTheGivenAdminNotExist($admin)){
            return redirect()->route('Admin.index');
        }

         // if the admin is administrator cancel the operation
        if(!$this->checkIfAllowedToDeleteOrUpdate($admin)){
            self::NotAuthorized();
            return redirect()->route('Admin.index');
        }
         // if the image is the default not remove it
        if($admin->avatar !== mainPath(_ADMIN.'/'.DEFAULT_AVATAR)){
            if(File::exists(fullPath($admin->avatar))){
                  // check the file already exists in hdd
                File::delete(fullPath($admin->avatar));
             }   
        }
        
        if($admin->delete()){
            self::Success();
        }else{
            self::Fail();
        }
        return redirect()->route('Admin.index');
    }


  
    private function checkIfTheGivenAdminNotExist($admin){
        if(!$admin){
            // if admin or id not found
            self::NotFound();
            return true;
        }
    }


    private function checkIfAllowedToDeleteOrUpdate($admin){
    
        if($admin->group === $this->administrationGroup){
            // the admin who we will do some operation (update-delete) is administrator
             return false; // not allowed
        }else{
            // the given admin is not the administrator or not super admin
            return true; // allowed
        }
    }


}