<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class SubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'sub_categories';
    protected $fillable = ['name_en','name_ar', 'image','category_id','properties','sort'];
    protected $appends = ['photo','name','text'];

    public function category(): ?BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function products(): ?HasMany
    {
        return $this->hasMany(Product::class)->where('available', 1)
        ;
    }
    public function getPhotoAttribute(): ?string
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('public/storage/sub_categories/' . $this->attributes['image']) : null) : null;

    }
    public function getTextAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['name_en'] ?? $this->attributes['name_ar'];
        } else {
            return $this->attributes['name_ar'] ?? $this->attributes['name_en'];
        }
    }
    public function getNameAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['name_en'] ?? $this->attributes['name_ar'];
        } else {
            return $this->attributes['name_ar'] ?? $this->attributes['name_en'];
        }
    }
}
