<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printprice extends Model
{

    protected $fillable = [
        'product_base',
        'color_code',
        'position',
        'print_model',
        'min_qty',
        'price',
        'setup'
    ];
}
