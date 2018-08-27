<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    protected $fillable = [
        'product_id',
        'qty',
        'date',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }


}
