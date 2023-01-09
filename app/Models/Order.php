<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    const STATUS_PENDDING = 0;
    const STATUS_ONPROGRESS = 2;
    const STATUS_DONE = 2;
}
