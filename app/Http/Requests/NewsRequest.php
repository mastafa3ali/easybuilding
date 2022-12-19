<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rules['title']      = 'required';
        $rules['new_date'] = 'required';
        $rules['description'] = 'required';
        $rules['image'] = 'required|image|mimes:jpg,jpeg,png,svg,webp,gif';

        return $rules;
    }
}
