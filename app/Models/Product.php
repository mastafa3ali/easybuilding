<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'description', 'type','category_id', 'guarantee_amount', 'properties', 'price','sub_category_id','image'];
    protected $appends = ['photo'];

    public const Properity_NONE = 1;
    public const Properity_LENGTH_WIDTH = 2;
    public const Properity_LENGTH_WIDTH_HEIGHT = 3;
    public const TYPE_SALE = 1;
    public const TYPE_RENT = 2;

    public function category():?BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory():?BelongsTo
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public static function saved($id)
    {
        if (auth()->check()) {
            return Saved::where('user_id',auth()->id())->where('model_id',$id)->where('model_type',Saved::TYPE_PRODUCT)->first() ? 1 : 0;
        }
        return 0;
    }

    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/products/' . $this->attributes['image']) : null) : null;

    }
}
