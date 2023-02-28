<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';
    protected $fillable = ['title', 'image','sort'];
    protected $appends = ['photo'];

    protected static $orderByColumn = 'sort';
    protected static $orderByColumnDirection = 'ASC';


    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/categories/' . $this->attributes['image']) : null) : null;

    }
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
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
