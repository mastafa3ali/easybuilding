<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $data =[];
        $data['id']         = $this->id;
        $data['name']       = $this->name;
        $data['email']      = $this->email;
        $data['phone_code']      = $this->phone_code;
        $data['phone']      = $this->phone;
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;
        $data['image'] = $this->photo;
        $data['token'] = $this->token;
        return $data;
    }

}
