<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Saved extends Model
{
    use HasFactory;
    protected $fillable = ['model_id', 'model_type', 'user_id'];
    const TYPE_PRODUCT = 1;
    const TYPE_COMPANY = 2;

    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
