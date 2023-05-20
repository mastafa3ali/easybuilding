<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        $data =[];
        $data['id']             = $this->id;
        $data['company_id']   = $this->company?->id;
        $data['product_id']  = $this->product?->id;
        $data['company_name']   = $this->company?->name;
        $data['company_photo']  = $this->company?->photo;
        $data['product_photo']  = $this->product?->photo;
        $data['total']          = $this->total;
        $data['status']          = $this->status;

        return $data;
    }


}
