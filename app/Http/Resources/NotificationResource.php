<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            '30-12-2022'  => [
                'text'=>'تم اتمام العملية بنجاح',
                'time'=>'3:40',
            ],
            '25-12-2022'  => [
                'text'=>'تم اتمام العملية بنجاح',
                'time'=>'3:40',
            ],
            '22-12-2022'  => [
                'text'=>'تم اتمام العملية بنجاح',
                'time'=>'3:40',
            ],
            '20-12-2022'  => [
                'text'=>'تم اتمام العملية بنجاح',
                'time'=>'3:40',
            ],
        ];
    }


}
