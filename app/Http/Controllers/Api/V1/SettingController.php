<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Term;

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
        $data = Setting::where('key', 'LIKE', 'about_%')->get();

        return apiResponse(true, $data, null, null, 200);
    }

    public function terms($company_id)
    {
        $data = Term::where('company_id', $company_id)->first();

        return apiResponse(true, $data, null, null, 200);
    }

    public function privacy()
    {
        $data = Setting::where('key', 'LIKE', 'privacy_')->get();

        return apiResponse(true, $data, null, null, 200);
    }
}
