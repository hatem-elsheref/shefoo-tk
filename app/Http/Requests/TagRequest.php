<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
{
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
        $id = $this->route('Tag') ?? null;

        $tableName = 'tags';
        $columnName = 'name';
        $rules['name'] =['required','string','min:1','max:191'];

        $rules['name'][] = (is_null($id)) ? Rule::unique($tableName,$columnName) : Rule::unique($tableName,$columnName)->ignore($id);

        return $rules;
    }
}