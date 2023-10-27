<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';
    protected $fillable = ['title_en','title_ar', 'image','sort','active'];
    protected $appends = ['photo','title','text'];

    protected static $orderByColumn = 'sort';
    protected static $orderByColumnDirection = 'ASC';


    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('public/storage/categories/' . $this->attributes['image']) : null) : null;

    }
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function getTextAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['title_en'] ?? $this->attributes['title_ar'];
        } else {
            return $this->attributes['title_ar'] ?? $this->attributes['title_en'];
        }
    }

    public function getTitleAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['title_en'] ?? $this->attributes['title_ar'];
        } else {
            return $this->attributes['title_ar'] ?? $this->attributes['title_en'];
        }
    }
    //  protected static function boot()
    //  {
    //      parent::boot();

    //         // static::creating(function ($query) {
    //         //     $query->created_by = auth()->id();
    //         // });
    //          static::retrieved(function ($query) {
    //             $query->orderBy('sort','DESC');
    //         });

    // }
}
