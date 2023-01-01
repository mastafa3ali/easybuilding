<?php

namespace App\Http\Controllers\Api\V1;

class TestHeadersController
{
    public function test()
    {
        return request()->header();
    }
}
