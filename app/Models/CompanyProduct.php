<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProduct extends Model
{
    use HasFactory;
    protected $table = "company_products";
    protected $fillable = ['company_id','product_id','price','guarantee_amount'];
    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
