<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Track extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tracks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'created_by', 'active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function studentsTrack()
    {
        return $this->hasMany(StudentTrack::class);
    }
}
