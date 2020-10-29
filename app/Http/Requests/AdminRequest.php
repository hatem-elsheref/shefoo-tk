<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{

    private $adminId;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       

        $this->adminId=$this->route('Admin');
        
       // this rule valid for store/update method
        $rules=[
            'name'    =>'required|string|max:191',
            'image'   =>'image|mimes:png,jpg,jpeg,webp|max:'.ADMIN_AVATAR_MAX_SIZE,
            'status'  =>'in:on|nullable',
            'group'   =>'required|numeric|exists:groups,id'
          ];

          // for store method only
        if(is_null($this->adminId)){
             $rules['email']    ='required|string|max:191|unique:admins,email';    
             $rules['password'] ='required|string|max:191|min:'.ADMIN_PASSWORD_LENGTH;    
        }else{
            // for update method only
             $rules['email'] =['required','string','max:191',Rule::unique('admins','email')->ignore($this->adminId)];
             $rules['password'] ='nullable|max:191|min:'.ADMIN_PASSWORD_LENGTH;        
        }

        return $rules;
    
}

}