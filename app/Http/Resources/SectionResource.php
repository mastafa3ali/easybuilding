<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    public function toArray($request)
    {
        $bookedStatus = 0;
        if ($this->transaction) {
            $bookedStatus = 1;
            $dateNow = date("Y-m-d");
//            if ($dateNow > date("Y-m-d", strtotime($this->transaction->end_date))) {
//                $bookedStatus = 2;
//            }
        }
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'price' => $this->price,
            'price2' => $this->price2,
            'discount'  => $this->discount ?? 0,
            'transactions_status' => $bookedStatus,
            'lessons' => LessonResource::collection($this->whenLoaded('lessons'), 1),
        ];
    }

    public function with($request)
    {
        return [
            'version' => '1.0',
            'success' => true,
            'status'  => 200
        ];
    }
}
