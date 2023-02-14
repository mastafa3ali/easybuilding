<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProduct extends Model
{
    use HasFactory;
    protected $table = "company_products";
    protected $fillable = ['company_id','product_id','price','guarantee_amount','image','description'];
       protected $appends = ['photo'];
    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/products/' . $this->attributes['image']) : null) : null;

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
