<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTrack extends Model
{
    use HasFactory;
    protected $table = 'student_tracks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'track_id'
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function track()
    {
        return $this->belongsTo(User::class, 'track_id');
    }
    
}
