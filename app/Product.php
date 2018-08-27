<?php

namespace App;

use function GuzzleHttp\default_ca_bundle;
use Illuminate\Database\Eloquent\Model;
use App\Printprice;

class Product extends Model
{
    protected $fillable = [
        'product_number',
        'product_base',
        'name',
        'slug',
        'color',
        'size',
        'catalog',
        'stock',
        'min',
        'category1',
        'category2',
        'category3',
        'short_description',
        'long_description',
        'dimensions',
        'material_type',
        'gender',
        'start_price',
        'position',
        'print_model',
    ];

    public function getColorCodeAttribute()
    {
        return substr($this->attributes['product_number'], 7,2);
    }

    public function getImageLinkAttribute($w, $h, $o = '')
    {
        $other = $o != '' ? '_' . $o : '';

        $prodBase = Product::where('product_base', $this->product_base)
            ->where('color', $this->color)
            ->where('position', $this->position)
            ->where('print_model', $this->print_model)
            ->first()
            ->product_number;

        $variation = '';

        $positions = Product::where('product_base', $this->product_base)
            ->where('color', $this->color)
            ->select('product_base', 'color', 'position', 'print_model')
            ->groupBy('product_base', 'color', 'position', 'print_model')
            ->get();

        if ($positions->count() > 1)
        {
            $variation = '_' . strtoupper(substr($this->position, 0 ,1)) . $this->print_model;
        }

        $imageFolder = '/images/products/' . $w . 'x' . $h . '/';

        $imageUrl = strtoupper(substr(str_replace('-', '_', $prodBase), 0 ,9)) . $variation . $other . ".jpg";

        $url =  $imageFolder . $imageUrl;

        if (!file_exists( public_path() . $url))
        {

            $imageUrl = strtoupper(substr(str_replace('-', '_', $prodBase), 0 ,9)) . $other . ".jpg";

            $url =  $imageFolder . $imageUrl;

            if (!file_exists( public_path() . $url))
            {
                $imageUrl = strtoupper(substr(str_replace('-', '_', $prodBase), 0 ,9)) . $o;
                $url = 'http://images.midoceanbrands.com/image.mvc/WithIcon/' . $imageUrl . '/' . $w . '/' . $h .'/';
            }

        }

        return $url;
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->attributes['price']/100, 2);
    }

    public function prices()
    {
        return $this->hasMany('App\Price');
    }

    public function arrivals()
    {
        return $this->hasMany('App\Arrival');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order')->withPivot('quantity');
    }

    public function getFinalPrice($qty)
    {
        $color_code = substr(Product::where('product_base', '=', $this->product_base)->where('color', '=', $this->color)->first()->product_number, 7,2);
        if (!isset(Product::where('product_base', '=', $this->product_base)->where('color', '=', $this->color)->where('position', '=', $this->position)->where('print_model', '=', $this->print_model)->first()->prices()->where('min_qty', '<=', $qty)->orderBy('min_qty', 'desc')->first()->price))
            return 0;

        if (!isset(Printprice::where('product_base', '=', $this->product_base)->where('color_code', '=', $color_code)->where('position', '=', $this->position)->where('print_model', '=', $this->print_model)->where('min_qty', '<=', $qty)->orderBy('min_qty', 'desc')->first()->price))
            return 0;

        $printPrice = $this->getFinalPrintPrice($qty);

        $prodPrice = $this->getFinalProdPrice($qty);

        $finalPrice = ($prodPrice + $printPrice) * 1.5;

        return $finalPrice;
    }

    public function getFinalPrintPrice($qty)
    {
        $color_code = substr(Product::where('product_base', '=', $this->product_base)->where('color', '=', $this->color)->first()->product_number, 7,2);
        $printPrice = Printprice::where('product_base', '=', $this->product_base)->where('color_code', '=', $color_code)->where('position', '=', $this->position)->where('print_model', '=', $this->print_model)->where('min_qty', '<=', $qty)->orderBy('min_qty', 'desc')->first()->price;
        $setupPrice = $this->getSetupPrice($qty);

        $finalPrice = $qty * $printPrice + $setupPrice;

        return $finalPrice;
    }

    public function getFinalProdPrice($qty)
    {
        $prodPrice = Product::where('product_base', '=', $this->product_base)->where('color', '=', $this->color)->where('position', '=', $this->position)->where('print_model', '=', $this->print_model)->first()->prices()->where('min_qty', '<=', $qty)->orderBy('min_qty', 'desc')->first()->price;

        $finalPrice = $qty * $prodPrice;

        return $finalPrice;
    }

    public function getSetupPrice($qty)
    {
        $color_code = substr(Product::where('product_base', '=', $this->product_base)->where('color', '=', $this->color)->first()->product_number, 7,2);
        $setupPrice = Printprice::where('product_base', '=', $this->product_base)->where('color_code', '=', $color_code)->where('position', '=', $this->position)->where('print_model', '=', $this->print_model)->where('min_qty', '<=', $qty)->orderBy('min_qty', 'desc')->first()->setup;

        return $setupPrice;
    }

    public function getStockQuantity()
    {
        $quantity = $this->stock;

        foreach ($this->arrivals()->get() as $arrival)
        {
            $quantity += $arrival->qty;
        }

        return $quantity;
    }

    public function catIcon() {
        switch ($this->category1)
        {
            case('ABBIGLIAMENTO'):
                return 'icon-tshirt';
                break;

            case('ATTREZZI E TORCE'):
                return 'icon-tools2';
                break;

            case('BORSE & VIAGGI'):
                return 'icon-briefcase2';
                break;

            case('CASA & VIVERE'):
                return 'icon-home2';
                break;

            case('CURA PERSONALE'):
                return 'icon-heart-pulse';
                break;

            case('PREMIUMS'):
                return 'icon-diamond';
                break;

            case('SCRITTURA'):
                return 'icon-pencil';
                break;

            case('SUONO E IMMAGINE'):
                return 'icon-music';
                break;

            case('TEMPO'):
                return 'icon-clock';
                break;

            case('TEMPO LIBERO'):
                return 'icon-drink';
                break;

            case('UFFICIO'):
                return 'icon-laptop-phone';
                break;

            default:
                return 'icon-cart';
                break;
        }
    }

}