<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        $data =[];
        $data['id']                  = $this->id;
        $data['name']                = $this->name;
        $data['phone']               = $this->phone;
        if(isset($this->price)){
            $data['price']           = $this->price;
        }
        if(isset($this->price_2)){
            $data['price_2']           = $this->price_2;
        }
        if(isset($this->price_3)){
            $data['price_3']           = $this->price_3;
        }
        if(isset($this->price_4)){
            $data['price_4']           = $this->price_4;
        }
       
        if(isset($this->product_image)){
            $data['product_image']           = asset('storage/products/' . $this->product_image);
        }else{
            $data['product_image']           = null;
        }
        if(isset($this->guarantee_amount)){
            $data['guarantee_amount']           =  $this->guarantee_amount;
        }else{
            $data['guarantee_amount']           = null;
        }
        $data['description']         = $this->description;
        $data['rent_type']           = isset($this->rent_type) ? __('products.rent_types.'.$this->rent_type): null;
        $data['saved']               = User::saved($this->id);
        $data['image']               = $this->photo;
        $data['rate']               = $this->rate;
        return $data;
    }


}
