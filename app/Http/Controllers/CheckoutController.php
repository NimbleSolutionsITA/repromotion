<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderPlaced;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Order;
use App\OrderProduct;
Use Illuminate\Support\Facades\Mail;
use App\User;

class CheckoutController extends Controller
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
            $shipping = 9;

        if (Cart::count() == 0)
        {
            session()->flash('message', "Special message goes here");
            return redirect()->back();
        }
        else
            return view('checkout')->with([
                'shipping' => $shipping,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        $contents = Cart::instance('default')->content()->map(function($item) {
           return $item->model->slug.', '.$item->qty;
        })->values()->toJson();

        if ($request->payment_method == 'stripe')
        {
            try {
                $charge = Stripe::charges()->create([
                    'amount' => $this->getNumbers()->get('newSubtotal'),
                    'currency' => 'EUR',
                    'source' => $request->stripeToken,
                    'description' => 'Order',
                    'receipt_email' => $request->email,
                    'metadata' => [
                        //change the order ID after we start using DB
                        'contents' => $contents,
                        'quantity' => Cart::instance('default')->count(),
                        'discount' => collect(session()->get('coupon'))->toJson(),
                    ],
                ]);

                // SUCCESSFUL
                $order = $this->addToOrdersTables($request, null);

                Mail::send(new OrderPlaced($order));

                Cart::instance('default')->destroy();
                session()->forget('coupon');

                //return back()->with('success_message', 'Thank you! your payment has been successfully accepted!');
                return redirect()->route('confirmation.index')->with('success_message', 'Grazie per il tuo acquisto! Il pagamento è stato accettato!');

            } catch (CardErrorException $e) {
                $this->addToOrdersTables($request, $e->getMessage());
                return back()->withErrors('Error! ' . $e->getMessage());

            }
        }
        else
        {

            // SUCCESSFUL
            $order = $this->addToOrdersTables($request, null);

            Mail::send(new OrderPlaced($order));

            Cart::instance('default')->destroy();
            session()->forget('coupon');

            //return back()->with('success_message', 'Thank you! your payment has been successfully accepted!');
            return redirect()->route('confirmation.index')->with('success_message', 'Grazie per il tuo acquisto! Il tuo ordine è stato creato!');
        }

    }

    protected function addToOrdersTables($request, $error)
    {
        $status = 'In attesa di pagamento';

        if ($request->payment_method == 'stripe')
             $status = 'Pagato';

        $shipping_name = isset($request->shipping_name) ? $request->shipping_name : $request->name;
        $shipping_address = isset($request->shipping_address) ? $request->shipping_address : $request->address;
        $shipping_city = isset($request->shipping_city) ? $request->shipping_city : $request->city;
        $shipping_province = isset($request->shipping_province) ? $request->shipping_province : $request->province;
        $shipping_cap = isset($request->shipping_cap) ? $request->shipping_cap : $request->cap;
        $shipping_phone = isset($request->shipping_phone) ? $request->shipping_phone : $request->phone;

        // insert into orders table
        $order = Order::create([
            'user_id' => auth()->user()  ? auth()->user()->id : null,
            'shipping_name' => $shipping_name,
            'shipping_address' => $shipping_address,
            'shipping_city' => $shipping_city,
            'shipping_province' => $shipping_province,
            'shipping_postcode' => $shipping_cap,
            'shipping_phone' => $shipping_phone,
            'notes' => $request->notes,
            'payment_gateway' => $request->payment_method,
            'status' => $status,
            'shipping' => $request->shipping,
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal(),
            'total' => Cart::total(),
            'error' => $error,
        ]);

        $user = User::find(auth()->user()->id)->update([
            'name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_cap' => $request->cap,
            'billing_phone' => $request->phone,
            'billing_piva' => $request->piva,
            'shipping_name' => $shipping_name,
            'shipping_address' => $shipping_address,
            'shipping_city' => $shipping_city,
            'shipping_province' => $shipping_province,
            'shipping_cap' => $shipping_cap,
            'shipping_phone' => $shipping_phone,

        ]);

        // insert into order_product table
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
                'price' => $item->subtotal,
            ]);
        }

        return $order;
    }

    private function getNumbers()
    {
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubtotal = (Cart::subtotal() - $discount);
        $code = session()->get('coupon')['discount'] ?? 0;
        $newTotal = $newSubtotal;

        return collect([
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTotal' => $newTotal,
            'code' => $code,
        ]);
    }
}
