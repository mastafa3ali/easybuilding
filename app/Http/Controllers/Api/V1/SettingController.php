<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Setting;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function contact()
    {
        $items = Setting::whereIn('key', ['general_email','general_phone','general_whatsapp','general_address'])->get();

        $data = [
            'email' => $items->where('key', 'general_email')->first()->value ?? '',
            'phone' => $items->where('key', 'general_phone')->first()->value ?? '',
            'whatsapp' => $items->where('key', 'general_whatsapp')->first()->value ?? '',
            'address' => $items->where('key', 'general_address')->first()->value ?? '',
        ];

        return apiResponse(true, $data, null, null, 200);
    }

    public function about()
    {
        $data = [
            'content' => Setting::where('key', 'LIKE', 'about_content')->value('value')
        ];

        return apiResponse(true, $data, null, null, 200);
    }

    public function terms()
    {
        $data = [
            'content' => Setting::where('key', 'LIKE', 'terms_content')->value('value')
        ];

        return apiResponse(true, $data, null, null, 200);
    }

    public function privacy()
    {
        $data = [
            'content' => Setting::where('key', 'LIKE', 'privacy_content')->value('value')
        ];

        return apiResponse(true, $data, null, null, 200);
    }
}
