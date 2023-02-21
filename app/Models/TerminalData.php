<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalData extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'category_id', 'properity_1', 'properity_2', 'properity_3'];
    
}
