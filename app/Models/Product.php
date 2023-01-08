<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;    
    protected $fillable = ['name', 'description', 'type','category_id', 'guarantee_amount', 'properties', 'price', 'company_id'];

    public const Properity_NONE = 1;
    public const Properity_LENGTH_WIDTH = 2;
    public const Properity_LENGTH_WIDTH_HEIGHT = 3;
    public const TYPE_SALE = 1;
    public const TYPE_RENT = 2;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}
