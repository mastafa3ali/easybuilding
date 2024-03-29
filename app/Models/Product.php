<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name_en','name_ar', 'description_en','description_ar', 'type','category_id', 'guarantee_amount', 'properties', 'price','sub_category_id','image','company_id','images','rate','available'];
    protected $appends = ['photo','photos','name','description','text'];
    protected $casts = [
        'images' => 'array'
    ];
    public const Properity_NONE = 1;
    public const Properity_LENGTH_WIDTH = 2;
    public const Properity_LENGTH_WIDTH_HEIGHT = 3;
    public const TYPE_SALE = 1;
    public const TYPE_RENT = 2;

    public function comapny(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }
    public function category(): ?BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subcategory(): ?BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public static function saved($id)
    {
        if (auth()->check()) {
            return Saved::where('user_id', auth()->id())->where('model_id', $id)->where('model_type', Saved::TYPE_PRODUCT)->first() ? 1 : 0;
        }
        return 0;
    }

    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('public/storage/products/' . $this->attributes['image']) : null) : null;

    }
    public function getPhotosAttribute()
    {
        $images = [];
        if(array_key_exists('images', $this->attributes) && $this->attributes['images'] != null) {
            foreach (json_decode($this->attributes['images']) as $image) {
                $images[] = asset('public/storage/products/' . $image);
            }
        }
        return $images;
    }


    public function getNameAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['name_en'] ?? $this->attributes['name_ar'];
        } else {
            return $this->attributes['name_ar'] ?? $this->attributes['name_en'];
        }
    }

    public function getDescriptionAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['description_en'] ?? $this->attributes['description_ar'];
        } else {
            return $this->attributes['description_ar'] ?? $this->attributes['description_en'];
        }
    }
    public function getTextAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['name_en'] ?? $this->attributes['name_ar'];
        } else {
            return $this->attributes['name_ar'] ?? $this->attributes['name_en'];
        }
    }

}
