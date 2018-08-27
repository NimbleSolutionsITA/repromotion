<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printinfo extends Model
{
    protected $fillable = [
        'product_base_number',
        'printing_position',
        'printing_technique',
        'printing_technique_description',
        'print_model',
        'pricing_type',
        'area',
        'number_of_colours',
        'manipulation',
        'color_code',
        'min_qty',
        'price',
        'setup',
        'handling',
        'apply',
    ];
}
