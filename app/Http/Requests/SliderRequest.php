<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        if ($this->method() == 'PUT') {
            return [
                'title' => 'required'
            ];
        }else{
            return [
                'title' => 'required',
                'image' => 'required',
            ];
        }
    }
}
