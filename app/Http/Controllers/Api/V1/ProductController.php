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
                $query->where('name', 'LIKE', '%' . $request->name . '%');
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


    public function show($id)
    {
        $item = Product::findOrFail($id);
        return apiResponse(true, new ProductResource($item), '', null, 200);
    }
    public function setSaved(Request $request)
    {
        // $item = Product::findOrFail($id);
        // return apiResponse(true, new ProductResource($item), '', null, 200);
    }
    public function getSaved(Request $request)
    {
        // $item = Product::findOrFail($id);
        // return apiResponse(true, new ProductResource($item), '', null, 200);
    }
}
