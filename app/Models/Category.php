<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['title', 'image'];
    protected $appends = ['photo'];
    public function getPhotoAttribute()
    {
        return $this->attributes['image'] != null ? asset('storage/categories/' . $this->attributes['image']) : null;
    }
}
