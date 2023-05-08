<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'photo' => $this->photo,
            'images' => $this->photos,
            'price' => $this->price,
            'description' => $this->description,
            'type'  => $this->type,
            'rate'  => $this->rate,
            'guarantee_amount' => $this->guarantee_amount,
            'properties' => $this->subcategory?->properties,
            'saved' => Product::saved($this->id)
        ];
    }


}
