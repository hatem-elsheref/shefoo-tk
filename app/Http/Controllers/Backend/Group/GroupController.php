<?php

namespace App\Http\Controllers\Backend\Group;
use APP\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{

    private $group;
    

    // constructor to initialize the values and check the authorization by middleware
    public function __construct(){

        $this->middleware('authorized:read_group')->only('index');
        $this->middleware('authorized:create_group')->only(['create','store']);
        $this->middleware('authorized:update_group')->only(['edit','update']);
        $this->middleware('authorized:delete_group')->only(['destroy']);
    }

    // show all groups in table
    public function index(){
        // get all groups in database with the permissions relation using eager loading
        $groups=Group::with(['admins','permissions'=>function($query){
            $query->select('display_name');
         }])->select('id','name','display_name')
            ->where('name','!=',config('trusting.administratorGroup')['name'])->get();

        // return the view with the data
        return view('backend.group.index',compact('groups'));
    }
    // show create group form
    public function create(){
        // return the view of create new group
        $models=config('trusting.models');
        $map=config('trusting.map');
        $permissions=Permission::select('id','name')->get()->toArray();
        return view('backend.group.create',['models'=>$models,'map'=>$map,'permissions'=>$permissions]);
    }
    // store the group in database
    public function store(Request $request){
        $request->validate([
            'name'          =>['required','string','max:191',Rule::unique('groups','name')],
            'display_name'  =>'required|string|max:191',
            'permissions'   =>'required|array|min:1'
        ]);
        $group=Group::create([
            'name'  =>$request->name,
            'display_name'  =>$request->display_name
        ]);
        if ($group){
            $group->permissions()->attach($request->permissions);
            self::Success();
        }else{
            self::Fail();
        }
        return redirect()->route('group.index');
    }
    // show the selected group data in form to make update
    public function edit($name){
        if($this->getGroup($name)){
            // group founded with this name
            if ($this->group != config('trusting.administratorGroup')['name']){
                // return the view of edit the selected group
                $models=config('trusting.models');
                $map=config('trusting.map');
                $permissions=Permission::select('id','name')->get()->toArray();
                return view('backend.group.edit',['models'=>$models,'map'=>$map,'permissions'=>$permissions])->with('group',$this->group);
            }
            // this is the super admin group you can't update or delete it
            self::NotAuthorized();
            redirect()->route('group.index');
        }
        // group not founded with the provided name
        self::NotFound();
        return redirect()->route('group.index');
    }
    // update the selected group in database
    public function update(Request $request,$name){
        if($this->getGroup($name)){
            // group already exists and set in the group property
            $request->validate([
                'name'          =>['required','string','max:191',Rule::unique('groups','name')->ignore($this->group->id)],
                'display_name'  =>'required|string|max:191',
                'permissions'   =>'required|array|min:1'
            ]);
            $this->group->name=$request->name;
            $this->group->display_name=$request->display_name;
            $this->group->save();
            $this->group->permissions()->sync($request->permissions);
            self::Success();
        }else{
            self::NotFound();
        }
        return redirect()->route('group.index');
    }
    // delete the selected group from the database
    public function destroy($name){
        if($this->getGroup($name)){
            // the group founded with the provided name
            if ($this->group != config('trusting.administratorGroup')['name']){
                // this is not the main group (super admin)
                $this->group->delete();
                self::Success();
            }else{
                // this the the main super admin cant update/delete it
                self::NotAuthorized();
            }
        }else{
            // the group with the provided name not found
            self::NotFound();
        }
       return redirect()->route('group.index');
    }
    // search for the group by name and return true/false if founded/Not founded
    private function getGroup($name){
        $group=Group::where('name',$name)->first();
        if(!$group){
            // group with the provided name not found
            return false;
        }else{
            $this->group=$group;
            return true;
        }
    }
}

