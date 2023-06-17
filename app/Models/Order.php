<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Order extends Model
{

    use HasFactory;
    use SoftDeletes;
    const STATUS_PENDDING_X = -1;

    const STATUS_PENDDING = 1;

    const STATUS_ONPROGRESS = 2;

    const STATUS_DONE = 3;

    const STATUS_ON_WAY= 4;

    const STATUS_DELIVERD= 5;


    const STATUS_REJECT = 3;
    const TYPE_SALE = 1;
    const TYPE_RENT = 2;
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
        'localtion',
        'type',
        'product_id',
        'long',
        'lat',
        'reason'
    ];
    protected $appends = [
        'checkamount',
        'checkguaranteeamount',
        'attachmentpayment1',
        'attachmentpayment2'
    ];
    protected $casts = [
        'details' => 'array'
    ];
    public function company(){
        return $this->belongsTo(User::class, 'company_id');
    }
    public function productDetails($product_id){

        return Product::find($product_id);
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getAttachmentpayment1Attribute()
    {
        return array_key_exists('attachment1', $this->attributes) ? ($this->attributes['attachment1'] != null ? asset('storage/orders/' . $this->attributes['attachment1']) : asset("default.jpg")) : asset("default.jpg");

    }
    public function getAttachmentpayment2Attribute()
    {
        return array_key_exists('attachment2', $this->attributes) ? ($this->attributes['attachment2'] != null ? asset('storage/orders/' . $this->attributes['attachment2']) : asset("default.jpg")) : asset("default.jpg");

    }
    public function getCheckamountAttribute()
    {
        return array_key_exists('check_guarantee', $this->attributes) ? ($this->attributes['check_guarantee'] != null ? asset('storage/orders/' . $this->attributes['check_guarantee']) : asset("default.jpg")) : asset("default.jpg");

    }
    public function getCheckguaranteeamountAttribute()
    {
        return array_key_exists('check_guarantee_amount', $this->attributes) ? ($this->attributes['check_guarantee_amount'] != null ? asset('storage/orders/' . $this->attributes['check_guarantee_amount']) : asset("default.jpg")) : asset("default.jpg");

    }

}
