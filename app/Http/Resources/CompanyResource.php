<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        $data =[];
        $data['id']               = $this->id;
        $data['name']             = $this->company_name;
        $data['phone']            = $this->phone;
        $data['price']            = $this->price;
        $data['description']      = $this->description;
        $data['saved']            = savedCompany($this->id);
        $data['image']            = $this->photo;
        return $data;
    }


}
