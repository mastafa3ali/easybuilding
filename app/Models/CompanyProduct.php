<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CompanyProduct extends Model
{
    use HasFactory;
    protected $table = "company_products";
    protected $fillable = ['company_id','product_id','price','guarantee_amount','image','description_en','description_ar','images','rent_type','price_2','price_3','price_4','available'];
    protected $appends = ['photo','photos','description','name'];
    protected $casts = [
        'images' => 'array'
    ];
    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/products/' . $this->attributes['image']) : null) : null;

    }
    public function getPhotosAttribute()
    {
        $images = [];
        if(array_key_exists('images', $this->attributes) && $this->attributes['images'] != null) {
            foreach (json_decode($this->attributes['images']) as $image) {
                $images[] = asset('storage/products/' . $image);
            }
        }
        return $images;

    }
    public function getDescriptionAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['description_en'] ?? $this->attributes['description_ar'];
        } else {
            return $this->attributes['description_ar'] ?? $this->attributes['description_en'];
        }
    }

    public function getNameAttribute()
    {
        return $this->product?->name;
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
