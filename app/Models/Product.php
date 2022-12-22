<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;    
    protected $fillable = ['name', 'description', 'type', 'guarantee_amount', 'properties', 'price', 'company_id'];

    public const TYPE_SALE = 1;
    public const TYPE_RENT = 2;

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}
