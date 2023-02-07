<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\Saved;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SavedResource extends JsonResource
{
    public function toArray($request)
    {
        $data =[];
        $data['id']               = $this->id;
        $data['name']             = $this->name;
        if($this->model_type==Saved::TYPE_COMPANY){
            $data['saved']            = User::saved($this->id);
            $data['phone']            = $this->phone;
            $data['price']            = "120";
            $data['description']      = $this->description;
            $data['image']            = $this->photo;

        }else{
            $data['price'] = $this->price;
            $data['description'] = $this->description;
            $data['type']  = $this->type;
            $data['company']  = $this->company?->name;
            $data['guarantee_amount'] = $this->guarantee_amount;
            $data['properties'] = $this->properties;
            $data['saved'] = Product::saved($this->id);
        }
        return $data;
    }


}
