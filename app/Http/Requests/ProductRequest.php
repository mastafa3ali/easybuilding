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
            'category_id' => 'required|exists:categories,id',
            'properties' => 'required',
            'guarantee_amount' => 'required_if:type,2',
        ];
    }
}
