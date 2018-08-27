<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shipping_address',
        'shipping_country',
        'shipping_name',
        'shipping_city',
        'shipping_province',
        'shipping_postcode',
        'shipping_phone',
        'notes',
        'payment_gateway',
        'status',
        'shipping',
        'tax',
        'subtotal',
        'total',
        'error',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function products() {
        return $this->belongsToMany('App\Product')->withPivot('quantity', 'price');
    }
}