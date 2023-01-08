<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'type'  => $this->type,
            'company'  => $this->company->name,
            'guarantee_amount' => $this->guarantee_amount,
            'properties' => $this->properties,
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
