<?php

namespace App\Http\Resources;

use App\Models\CompanyProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $products = [];
        if ($this->type == 1) {
            foreach ($this->details as $product) {
                $company_product_id = CompanyProduct::where('company_id', $this->company?->id)->where('product_id', $product['id'])->first();
                $item['id'] = $company_product_id?->id; //company_product_id
                $item['name'] = $this->productDetails($product['id'])?->name ;
                $item['image'] = $this->productDetails($product['id'])?->photo;
                $item['qty'] = $product['qty'] ;
                $item['price'] = $product['price'] ?? '' ;
                $item['attribute_1'] = null;
                $item['attribute_2'] = null;
                $item['attribute_3'] = null;
                $item['rate'] = $this->productDetails($product['id'])?->rate;
                $products[] = $item;
            }
        } else {
            foreach ($this->details as $product) {

                $company_product_id = CompanyProduct::where('company_id', $this->company?->id)->where('product_id', $product['id'])->first();
                $item['id'] = $company_product_id?->id;
                //company_product_id
                $item['name'] = $this->productDetails($product['id'])?->name ;
                $item['image'] = $this->productDetails($product['id'])?->photo ;
                $item['qty'] = 1;
                $item['price'] = $product['price'] ?? '' ;
                $item['attribute_1'] = $product['attribute_1'];
                $item['attribute_2'] = $product['attribute_2'];
                $item['attribute_3'] = $product['attribute_3'];
                $item['rate'] = $this->productDetails($product['id'])?->rate;
                $products[] = $item;
            }
        }
        $data['id']                      = $this->id;
        $data['company_id']              = $this->company?->id;
        $data['products']                = $products;
        $data['company_name']            = $this->company?->name;
        $data['company_description']     = $this->company?->description;
        $data['company_rate']            = $this->company?->rate;
        $data['company_photo']           = $this->company?->photo;
        $data['total']                   = $this->total;
        $data['code']                    = $this->code;
        $data['status']                  = $this->status;
        $data['address']                 = $this->address;
        $data['phone']                   = $this->phone;
        $data['delivery_phone']          = $this->delivery_phone;
        $data['area']                    = $this->area;
        $data['delivery_date']           = $this->delivery_date;
        $data['payment']                 = $this->payment;
        $data['guarantee_amount']        = $this->guarantee_amount;
        $data['type']                    = $this->type;
        $data['created_at']              = $this->created_at;

        return $data;
    }


}
