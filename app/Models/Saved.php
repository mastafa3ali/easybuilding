<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Saved extends Model
{
    use HasFactory;
    protected $fillable = ['model_id', 'model_type', 'user_id'];

    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
