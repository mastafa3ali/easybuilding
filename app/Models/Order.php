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
    const STATUS_ONPROGRESS = 1;
    const STATUS_DONE = 2;
    protected $fillable = [
        'code',
        'address',
        'phone',
        'phone2',
        'delivery_phone',
        'area',
        'details',
        'attachment1',
        'attachment2',
        'delivery_date',
        'status',
        'payment',
        'guarantee_amount',
        'total',
        'user_id',
        'company_id',
        'check_guarantee',
        'check_guarantee_amount',
        'localtion'
    ];
}
