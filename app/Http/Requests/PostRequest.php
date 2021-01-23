<?php

namespace App\Http\Requests;

use App\Models\Blog\Tag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
        $id = $this->route('Post') ?? null;
        $this->status = strtolower($this->status);

        $tableName = 'posts';
        $columnName = 'title';
        $rules = [
            'title'     => ['required','string','max:191'],
            'status'    => ['required','in:published,drafted'],
            'meta'      => ['array','nullable'],
            'image'     => ['image','mimes:png,jpg,jpeg,gif,webp','nullable'],
            'category'  => ['required','numeric',Rule::exists('categories','id')],
            'tags'      => ['required','array','min:1',Rule::in(Tag::get('id')->pluck('id')->toArray())],
            'content'   =>['required','string']
        ];

        $rules['title'][] = is_null($id) ? Rule::unique($tableName,$columnName) : Rule::unique($tableName,$columnName)->ignore($id);

        return $rules;
    }
}
