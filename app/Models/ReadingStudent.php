<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingStudent extends Model
{
    use HasFactory;
    protected $table = 'reading_students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'readingcycle_id',
        'part_1', 'part_2', 'part_3', 'part_4', 'part_5', 'part_6', 'part_7', 'part_8', 'part_9', 'part_10', 'part_11', 'part_12', 'part_13', 'part_14', 'part_15', 'part_16', 'part_17', 'part_18', 'part_19', 'part_20', 'part_21', 'part_22', 'part_23', 'part_24', 'part_25', 'part_26', 'part_27', 'part_28', 'part_29', 'part_30'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function readingcycle()
    {
        return $this->belongsTo(User::class, 'readingcycle_id');
    }
}
