<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'sub_categories';
    protected $fillable = ['name', 'image','category_id'];
    protected $appends = ['photo'];

    public function category():?BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function products():?HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function getPhotoAttribute():?string
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/sub_categories/' . $this->attributes['image']) : null) : null;

    }
}
