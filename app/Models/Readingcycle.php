<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Readingcycle extends Model
{
    use HasFactory;
    protected $table = 'readingcycles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'created_by', 'active', 'track_id', 'supervisor_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function readingStudents()
    {
        return $this->hasMany(ReadingStudent::class);
    }
}
