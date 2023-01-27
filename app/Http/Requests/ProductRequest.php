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
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required|in:1,2',
            'category_id' => 'required_if:type,1|exists:categories,id',
            'sub_category_id' => 'required_if:type,2|exists:sub_categories,id',
            'properties' =>  'required_if:type,2',
            'guarantee_amount' => 'required_if:type,2',
        ];
    }
}
