<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'news';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'new_date', 'image', 'description', 'created_by',
    ];
    protected $appends = ['photo'];
    public function getPhotoAttribute()
    {
        return $this->attributes['image'] != null ? asset('public/storage/news/' . $this->attributes['image']) : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
