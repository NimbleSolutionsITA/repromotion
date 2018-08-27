<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'product_id',
        'min_qty',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }


}
