<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name_ar' => 'required',
            'name_en' => 'required',
            'type' => 'required|in:1,2',
            'category_id' => 'required_if:type,1',
            'sub_category_id' => 'required_if:type,2',
        ];
    }
}
