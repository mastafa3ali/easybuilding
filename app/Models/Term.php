<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Term extends Model
{
    use HasFactory;
    protected $table = "terms";

    protected $fillable = ['user_id','text_en','text_ar'];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        if(App::isLocale('en')) {
            return $this->attributes['text_en'] ?? $this->attributes['text_ar'];
        } else {
            return $this->attributes['text_ar'] ?? $this->attributes['text_en'];
        }
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
