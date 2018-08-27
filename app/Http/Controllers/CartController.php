<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Coupon;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipping = 0;

        if (Cart::instance('default')->count() > 0 && Cart::instance('default')->subtotal < 180)
            $shipping = 16;

        return view('cart')->with([
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'shipping' => $shipping,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cart::instance('totalPrice')->destroy();

        $prodColor = $request->color;
        $prodBase = $request->id;
        $position = $request->position;
        $print_model = $request->print_model;

        $prod = Product::where('product_base', '=', $prodBase)
            ->where('color', '=', $prodColor)
            ->where('position', '=', $position)
            ->where('print_model', '=', $print_model)
            ->get();

        $qtyTot = $request->qty_U + $request->qty_XS + $request->qty_S + $request->qty_M + $request->qty_L + $request->qty_XL + $request->qty_XXL + $request->qty_3XL + $request->qty_4XL + $request->qty_5XL;

        foreach (Cart::instance('default')->content() as $item)
        {
            if ($item->model->product_base == $prod->first()->product_base && $item->model->color == $prod->first()->color)
            {
                $qtyTot += $item->qty;
            }
        }

        if ($request->addCart == 'updatePriceU' || $request->addCart == 'updatePrice')
            $cartInstance = 'totalPrice';

        else
            $cartInstance = 'default';

        if ($cartInstance == 'default' && $qtyTot < $prod->first()->min)
        {
            $qty = $prod->first()->min;
            return \Redirect::back()->withErrors(['errore', 'Seleziona almeno '. $prod->first()->min . ' pezzi'])->withInput();
        }

        if($request->addCart == 'updatePriceU' || $request->addCart == 'addCartU')
        {
            if ($request->qty_U > 0)
            {
                $qty = $request->qty_U;

                foreach (Cart::instance($cartInstance)->content() as $item)
                {
                    if ($item->model->slug == $prod->first()->slug)
                    {
                        $qtyTot += $item->qty;
                    }
                }

                if ($cartInstance == 'default' && $qtyTot > $prod->first()->getStockQuantity())
                {
                    $qty = $prod->first()->min;
                    return \Redirect::back()->withErrors(['errore', 'Seleziona un massimo di '. $prod->first()->getStockQuantity() . ' pezzi' . ' per ' . $prod->first()->name . ' ' . $prod->first()->color])->withInput();
                }

                $cartProd = Cart::instance($cartInstance)->content()->where('id', '=', $prod->first()->id)->first();

                if ($cartProd)
                {
                    $qty += $cartProd->qty;
                }

                $prodPrice = $prod->first()->getFinalPrice($qty) / $qty;

                Cart::instance($cartInstance)
                    ->add(
                        $prod->first()->id,
                        $prod->first()->name .' - '. $prodColor . ' - ' . $position . ' - ' . $print_model,
                        $request->qty_U,
                        $prodPrice)
                    ->associate('App\Product');
            }
        }

        if($request->addCart == 'updatePrice' || $request->addCart == 'addCart')
        {

            $qty = $request->qty_XS + $request->qty_S + $request->qty_M + $request->qty_L + $request->qty_XL + $request->qty_XXL + $request->qty_3XL + $request->qty_4XL + $request->qty_5XL;

            $prodPrice = $prod->first()->getFinalPrice($qty) / $qty;

            if ($request->qty_XS > 0)
            {
                $this->cartSize($request->qty_XS, 'XS', $prod, $cartInstance, $prodPrice);
            }
            if ($request->qty_S > 0)
            {
                $this->cartSize($request->qty_S, 'S', $prod, $cartInstance, $prodPrice);
            }
            if ($request->qty_M > 0)
            {
                $this->cartSize($request->qty_M, 'M', $prod, $cartInstance, $prodPrice);
            }
            if ($request->qty_L > 0)
            {
                $this->cartSize($request->qty_L, 'L', $prod, $cartInstance, $prodPrice);
            }
            if ($request->qty_XL > 0)
            {
                $this->cartSize($request->qty_XL, 'XL', $prod, $cartInstance, $prodPrice);
            }
            if ($request->qty_XXL > 0)
            {
                $this->cartSize($request->qty_XXL, 'XXL', $prod, $cartInstance, $prodPrice);
            }
            if ($request->qty_3XL > 0)
            {
                $this->cartSize($request->qty_3XL, '3XL', $prod, $cartInstance, $prodPrice);
            }
            if ($request->qty_4XL > 0)
            {
                $this->cartSize($request->qty_4XL, '4XL', $prod, $cartInstance, $prodPrice);
            }
            if ($request->qty_5XL > 0)
            {
                $this->cartSize($request->qty_5XL, '5XL', $prod, $cartInstance, $prodPrice);
            }

            if ($cartInstance == 'default')
            {
                $qtyUp = 0;

                foreach (Cart::instance($cartInstance)->content() as $item)
                {
                    if ($item->model->product_base == $prod->first()->product_base && $item->model->color == $prod->first()->color)
                    {
                        $qtyUp += $item->qty;
                    }
                }

                $price = $prod->first()->getFinalPrice($qtyUp) / $qtyUp;

                foreach (Cart::instance($cartInstance)->content() as $item)
                {
                    if ($item->model->product_base == $prod->first()->product_base && $item->model->color == $prod->first()->color)
                    {
                        Cart::instance($cartInstance)->update($item->rowId, ['price' => $price]);
                    }
                }
            }
        }

        if ($cartInstance == 'default')
            return back()->with('success_message', 'Il prodotto è stato aggiunto al carrello')->withInput();

        else
            return back()->withInput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFavorite(Request $request)
    {
        Cart::instance('favorite')->add($request->id, $request->name, $request->product_quantity, $request->price)
            ->associate('App\Product');

        return back()->with('success_message', 'item was added to your favorite!');
    }

    public function empty()
    {
        Cart::destroy();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Cart::instance('default')->update($id, $request->product_quantity);

        $qty = 0;

        $prod = Product::where('id', Cart::instance('default')->get($id)->id)->first();

        foreach (Cart::instance('default')->content() as $item)
        {
            if ($item->model->product_base == $prod->product_base && $item->model->color == $prod->color)
            {
                $qty += $item->qty;
            }
        }

        $price = $prod->getFinalPrice($qty) / $qty;

        foreach (Cart::instance('default')->content() as $item)
        {
            if ($item->model->product_base == $prod->product_base && $item->model->color == $prod->color)
            {
                Cart::instance('default')->update($item->rowId, ['price' => $price]);
            }
        }

        return back()->with('success_message', 'La quantità nel carrello è stata aggiornata');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slug = Cart::get($id)->model->slug;
        $qty = 0;
        $price = 0;
        $items = 0;

        foreach (Cart::content() as $item)
        {
            if ($item->model->slug == $slug)
            {
                $items ++;
                $qty += $item->qty;
            }
        }

        $qty -= Cart::get($id)->qty;

        if ($qty < $item->model->min && $items > 1)
            return \Redirect::back()->withErrors(['errore', 'Seleziona almeno '. $item->model->min . ' pezzi'])->withInput();


        if ($qty > 0)
        {
            $price = Cart::get($id)->model->getFinalPrice($qty) / $qty;

            foreach (Cart::content() as $item)
            {
                if ($item->model->slug == $slug)
                {
                    Cart::update($item->rowId, ['price' => $price]);
                }
            }
        }

        Cart::remove($id);

        return back()->with('success_message', 'Il prodotto è stato rimosso dal carrello.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    private function getNumbers()
    {
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubtotal = (Cart::subtotal() - $discount);

        return collect([
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
        ]);
    }

    private function cartSize($qty, $size, $prod, $cartInstance, $prodPrice)
    {
        $prodSize = $prod->where('size', '=', $size)->first();
        $qtyTot = $qty;
        foreach (Cart::instance($cartInstance)->content() as $item)
        {
            if ($item->model->slug == $prodSize->slug && $item->model->size == $prodSize->size)
            {
                $qtyTot += $item->qty;
            }
        }
        if ($cartInstance == 'default' && $qtyTot > $prodSize->getStockQuantity())
        {
            $qty = $prodSize->min;
            return \Redirect::back()->withErrors(['errore', 'Seleziona un massimo di '. $prodSize->getStockQuantity() . ' pezzi' . ' per ' .  $prod->first()->name . ' ' .  $prod->first()->color . ' ' .   $prod->first()->size])->withInput();
        }
        Cart::instance($cartInstance)->add($prodSize->id, $prodSize->name .' - '. $prodSize->color .' - '. $prodSize->size, $qty, $prodPrice)
            ->associate('App\Product');
    }


}
