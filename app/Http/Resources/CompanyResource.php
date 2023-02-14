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
        $data['name']             = $this->name;
        $data['phone']            = $this->phone;
        if(isset($this->price)){

        $data['price']            = $this->price;
        }
        $data['description']      = $this->description;
        $data['saved']            = User::saved($this->id);
        $data['image']            = $this->photo;
        return $data;
    }


}
