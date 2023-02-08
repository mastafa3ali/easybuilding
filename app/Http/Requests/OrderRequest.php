<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class OrderRequest extends FormRequest
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
        return [
            'address' => 'sometimes|string|max:255',
            'phone' => 'required',
            'delivery_phone' => 'required',
            'deliver_date' => 'required',
            'area' => 'required',
            'product_id' => 'required|exists:products,id',
            'attribute_1' => 'required',
            'attribute_2' => 'required',
            'company_id' => 'required|exists:users,id',


        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(apiResponse(false, $errors, 'Validation Error', null, 401 ));
    }
}

