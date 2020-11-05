<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TranslationRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $locales=\LaravelLocalization::getSupportedLocales();
        $rule['newKey']='nullable|string|min:1';
        $rules['translationFile']=[Rule::requiredIf(!empty($this->newKey) or !is_null($this->newKey)),'string','min:1'];
        foreach ($locales as $localeCode => $properties){
            $rules['newValue.'.$localeCode]=[Rule::requiredIf(!empty($this->newKey) or !is_null($this->newKey))];
        }

        return $rules;
    }
}
