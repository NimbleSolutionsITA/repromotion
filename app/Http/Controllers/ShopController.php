<?php

namespace App\Http\Controllers;

use View;
use App\Product;
use App\Printinfo;
use App\Printprice;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShopController extends Controller
{
    /**
     * Show the shop page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cat1 = '', $cat2 = '')
    {

        $categories = Product::select('category1', 'category2')
            ->groupBy('category1', 'category2')
            ->get();

        $colors = Product::select('color')
            ->groupBy('color')
            ->get();

        $col = array();

        if (request()->has('color'))
        {
            switch (request()->color) {

                case 'verde':
                    array_push($col, 'lime');
                    array_push($col, 'verde');
                    break;

                case 'blu':
                    array_push($col, 'blu trasparente');
                    array_push($col, 'turchese');
                    array_push($col, 'blu');
                    array_push($col, 'Blu Azzurro');
                    array_push($col, 'Blu navy');
                    array_push($col, 'blu royal');
                    array_push($col, 'blu trasparente');
                    array_push($col, 'Atollo');
                    array_push($col, 'Royal');
                    break;

                case 'rosso':
                    array_push($col, 'borgogna');
                    array_push($col, 'fucsia');
                    array_push($col, 'rosso');
                    array_push($col, 'rosso trasparente');
                    break;

                case 'giallo':
                    array_push($col, 'giallo');
                    break;

                case 'grigio':
                    array_push($col, 'grigio');
                    array_push($col, 'argento');
                    array_push($col, 'argento lucido');
                    array_push($col, 'argento opaco');
                    break;

                case 'nero':
                    array_push($col, 'nero');
                    array_push($col, 'Nero / Nero Opaco');
                    break;

                case 'arancio':
                    array_push($col, 'arancio');
                    array_push($col, 'arancio trasparente');
                    break;

                case 'bianco':
                    array_push($col, 'Bianco');
                    break;

                case 'altro':
                    array_push($col, 'legno');
                    array_push($col, 'multicolore');
                    array_push($col, 'trasparente');
                    break;
            }
        }
        else
        {
            foreach ($colors as $item) {
                array_push($col, $item->color);
            }
        }

        $currentCat1 = $cat1;
        $currentCat2 = $cat2;

        $selectedCat = array();

        foreach ($categories as $category)
        {
            if ($cat1 == '')
                array_push($selectedCat, $category->category1);

            if (str_slug($category->category1) == $cat1)
            {
                array_push($selectedCat, $category->category1);
                $currentCat1 = $category->category1;
            }
            if (str_slug($category->category2) == $cat2)
            {
                $currentCat1 = $category->category1;
                $currentCat2 = $category->category2;
            }
        }

        $selectedCat = array_values(array_unique($selectedCat));

        if (request()->has('input_category'))
        {
            $selectedCat = request()->input_category;
        }

        $title = $currentCat1 = '' ? 'Shop' : $currentCat1;

        $sortBy = 'product_base';
        $order = 'asc';

        if (request()->has('sort')) {

            switch (request('sort')) {
                case 'naa':
                    $sortBy = 'name';
                    $order = 'asc';
                    break;
                case 'nad':
                    $sortBy = 'name';
                    $order = 'desc';
                    break;
                case 'pra':
                    $sortBy = 'start_price';
                    $order = 'asc';
                    break;
                case 'prd':
                    $sortBy = 'start_price';
                    $order = 'desc';
                    break;
            }
        }

        $keyword = request()->has('keyword') ?  request()->keyword : '';

        $priceMin = request()->has('amount') ? ltrim(explode(' ',trim(request()->amount))[0], '€') : 0;
        $priceMax = request()->has('amount') ? ltrim(explode(' ',trim(request()->amount))[2], '€') : 500;

        if (request()->has('keyword'))
        {
            $products = Product::where('start_price', '>', 0)
                ->where('name', 'like', '%'.request()->keyword.'%')
                ->orWhere('category1', 'like', '%'.$keyword.'%')
                ->orWhere('category2', 'like', '%'.$keyword.'%')
                ->orWhere('category3', 'like', '%'.$keyword.'%')
                ->select('product_base', 'name', 'slug', 'category1', 'category2', 'category3', 'start_price', 'color', 'position', 'print_model', 'material_type')
                ->groupBy('product_base', 'name', 'slug', 'category1', 'category2', 'category3', 'start_price', 'color', 'position', 'print_model', 'material_type')
                ->orderBy($sortBy, $order)
                ->paginate(12);

            return view('shop', compact(['title', 'products', 'categories', 'colors', 'productsNum', 'currentCat1', 'currentCat2', 'selectedCat']) );
        }

        else
        {
            $products = Product::where('start_price', '>', 0)
                ->whereIn('color', $col)
                ->whereIn('category1', $selectedCat)
                ->where('category2', 'like', '%'.$currentCat2.'%')
                ->where('start_price', '>=', $priceMin)
                ->where('start_price', '<=', $priceMax)
                ->select('product_base', 'name', 'slug', 'category1', 'category2', 'category3', 'start_price', 'color', 'position', 'print_model', 'material_type')
                ->groupBy('product_base', 'name', 'slug', 'category1', 'category2', 'category3', 'start_price', 'color', 'position', 'print_model', 'material_type')
                ->orderBy($sortBy, $order)
                ->paginate(12);

            return view('shop', compact(['title', 'products', 'categories', 'colors', 'currentCat1', 'currentCat2', 'selectedCat']) );
        }

    }

    public function show($cat1, $cat2, $slug)
    {
        $product = Product::where('start_price', '>', 0)
            ->where('slug', $slug)
            ->get();

        $price = $product->first()->start_price;
        $qty = $product->first()->min;
        $color_code = substr($product->first()->product_number, 7,2);
        $position = $product->first()->position;
        $printModel = $product->first()->print_model;


        if ($product->first() && Cart::instance('totalPrice')->count() > 0)
        {
            if ( $product->where('id', Cart::instance('totalPrice')->content()->first()->id)->first() )
            {
                $qty = Cart::count();
                $price = Cart::instance('totalPrice')->subtotal() / $qty;
            }
        }


        if (!$product)
            return view('errors.404',array(),404);

        $printinfos = Printinfo::where('product_base_number', $product->first()->product_base)->where('color_code', $color_code)->where('printing_position', $position)->where('print_model', $printModel)->get();
        $printprices = Printprice::where('product_base', $product->first()->product_base)->where('color_code', $color_code)->where('position', $position)->where('print_model', $printModel)->get();

        return view('product', compact(['product', 'printinfos', 'printprices', 'color', 'price', 'qty']));
    }
}