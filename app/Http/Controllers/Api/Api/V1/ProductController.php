<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $items = Product::where(function ($query) use ($request) {
            if ($request->filled('name')) {
                $query->where('name', 'LIKE', '%'.$request->name.'%');
            }
        })
                        ->paginate(20);

        return ProductResource::collection($items)->additional([
            'success' => true,
            'message' => null,
            'errors' => null,
            'status'  => 200
        ]);
    }

    public function addInvoice(Request $request)
    {
        $validate = array(
            'phone' => 'required',
            'address' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'pdf' => 'nullable|mimes:pdf|max:4096'
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }
    }
}
