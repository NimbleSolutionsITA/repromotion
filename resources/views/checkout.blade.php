@extends('layouts.app')

@section('title', 'Checkout')

@section('extra-css')
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        /**
         * The CSS shown here will not be introduced in the Quickstart guide, but shows
         * how you can use CSS to style your Element's container.
         */
        .StripeElement {
            background-color: transparent;
            height: 50px;
            padding: 15px 20px 11px;
            border-radius: 10px;
            border: 1px solid rgba(128, 128, 128, 0.5);
            font-size: 16px;
            line-height: 30px;
            font-weight: 400;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        span, td, p {
            color: #333e48;
        }

        #place_order {
            float: right;
            color: #333e48;
            border-color: #959a9e;
            border-width: 2px;
            padding: 15px 61px;
        }

        #place_order:hover {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
            color: white;
        }
    </style>


@endsection

@section('content')
    <!--breadcumb start here-->
    <div class="xs-breadcumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"> Home</a></li>
                    <li class="breadcrumb-item"><a href="/cart">Carrello </a></li>
                    <li class="breadcrumb-item"><a href="/cart/checkout">Checkout </a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!--breadcumb end here--><!-- End welcome section -->

    <div class="container">

        @include('partials.messages')

        <div class="row">
            <div class="col-sm-7 col-md-8 col-lg-8">
                <h2>Indirizzo di Fatturazione</h2>
                <form action="{{ route('checkout.store') }}" method="POST" class="form-horizontal checkout shop-checkout" role="form" id="payment-form" >
                    @csrf

                    <div class="form-group validate-required" id="name_field"> <label for="name" class="col-sm-6 control-label">
                            <span class="grey">Nome / Ragione sociale:</span>
                            <span class="required">*</span>
                        </label>
                        <div class="col-sm-9"> <input type="text" class="form-control " name="name" id="name" placeholder="" value="{{ Auth::user()->name }}" required> </div>
                    </div>

                    <div class="form-group address-field validate-required" id="address_field"> <label for="address" class="col-sm-6 control-label">
                            <span class="grey">Indirizzo:</span>
                            <span class="required">*</span>
                        </label>
                        <div class="col-sm-9"> <input type="text" class="form-control " name="address" id="address" placeholder="" value="{{  Auth::user()->billing_address }}" required> </div>
                    </div>

                    <div class="form-group address-field validate-required" id="city_field"> <label for="city" class="col-sm-6 control-label">
                            <span class="grey">Città:</span>
                            <span class="required">*</span>
                        </label>
                        <div class="col-sm-9"> <input type="text" class="form-control " name="city" id="city" placeholder="" value="{{ Auth::user()->billing_city }}" required> </div>
                    </div>

                    <div class="form-group address-field validate-state" id="province_field"> <label for="province" class="col-sm-6 control-label">
                            <span class="grey">Provincia:</span>
                        </label>
                        <div class="col-sm-9"> <input type="text" class="form-control " value="{{ Auth::user()->billing_province }}" placeholder="" name="province" id="province" required> </div>
                    </div>

                    <div class="form-group address-field validate-required validate-postcode" id="cap_field"> <label for="cap" class="col-sm-6 control-label">
                            <span class="grey">CAP:</span>
                            <span class="required">*</span>
                        </label>
                        <div class="col-sm-9"> <input type="number" class="form-control " name="cap" id="cap" placeholder="" value="{{ Auth::user()->billing_cap }}" required> </div>
                    </div>

                    <div class="form-group validate-required validate-email" id="email_field"> <label for="email" class="col-sm-6 control-label">
                            <span class="grey">Email:</span>
                            <span class="required">*</span>
                        </label>
                        <div class="col-sm-9"> <input type="email" class="form-control " name="email" id="email" placeholder="" value="{{ Auth::user()->email }}" required> </div>
                    </div>

                    <div class="form-group validate-required validate-phone" id="piva_field"> <label for="piva" class="col-sm-6 control-label">
                            <span class="grey">Codice Fiscale / Partita IVA:</span>
                            <span class="required">*</span>
                        </label>
                        <div class="col-sm-9"> <input type="text" class="form-control " name="piva" id="piva" placeholder="" value="{{ Auth::user()->billing_piva }}" required> </div>
                    </div>

                    <div class="form-group validate-required validate-phone" id="phone_field"> <label for="phone" class="col-sm-6 control-label">
                            <span class="grey">Telefono:</span>
                        </label>
                        <div class="col-sm-9"> <input type="text" class="form-control " name="phone" id="phone" placeholder="" value="{{ Auth::user()->billing_phone }}"> </div>
                    </div>

                    <div class="form-group validate-required validate-phone" id="notes_field"> <label for="notes" class="col-sm-6 control-label">
                            <span class="grey">Note:</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea rows="5" class="form-control " name="notes" id="notes" placeholder="Inserisci eventuali note per l'ordine" value="{{ old('notes') }}"></textarea>
                        </div>
                    </div>

                    <input type="hidden" value="{{ $shipping }}" id="shipping" name="shipping">

                    <div class="form-group form-stripe">

                        <div class="form-group validate-required" id="name_on_card_field"> <label for="name_on_card" class="col-sm-3 control-label">
                                <span class="grey">Nome sulla carta:</span>
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-9"> <input type="text" class="form-control " name="name_on_card" id="name_on_card" placeholder="" value="{{ old('name_on_card') }}" required> </div>
                        </div>
                        <label for="card-element" class="col-sm-6 control-label" style="color: #333;">
                            Carta di credito
                        </label>
                        <div class="col-sm-9">
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <!--
                    <div class="form-group">
                        <label for="order_comments" class="col-sm-3 control-label">
                            <span class="grey">Order Notes:</span>
                        </label>
                        <div class="col-sm-9"> <textarea name="order_comments" class="form-control" id="order_comments" placeholder="" rows="5"></textarea> </div>
                    </div>
                    -->
                    <div class="shop-info">Vuoi spedire ad un indirizzo diverso? <a data-toggle="collapse" href="#registeredForm" aria-expanded="false" aria-controls="registeredForm">Clicca qui</a> </div>
                    <div class="collapse" id="registeredForm">
                        <br>
                        <h2>Indirizzo di Spedizione</h2>

                        <div class="form-group validate-required" id="shipping_name_field">
                            <label for="shipping_name" class="col-sm-6 control-label">
                                <span class="grey">Nome / Ragione sociale:</span>
                            </label>
                            <div class="col-sm-9"> <input type="text" class="form-control " name="shipping_name" id="shipping_name" placeholder="" value="{{ Auth::user()->shipping_name}}"> </div>
                        </div>

                        <div class="form-group address-field validate-required" id="shipping_address_field">
                            <label for="shipping_address" class="col-sm-6 control-label">
                                <span class="grey">Indirizzo:</span>
                            </label>
                            <div class="col-sm-9"> <input type="text" class="form-control " name="shipping_address" id="shipping_address" placeholder="" value="{{ Auth::user()->shipping_address }}"> </div>
                        </div>

                        <div class="form-group address-field validate-required" id="shipping_city_field">
                            <label for="shipping_city" class="col-sm-6 control-label">
                                <span class="grey">Città:</span>
                            </label>
                            <div class="col-sm-9"> <input type="text" class="form-control " name="shipping_city" id="shipping_city" placeholder="" value="{{ Auth::user()->shipping_city }}"> </div>
                        </div>

                        <div class="form-group address-field validate-state" id="shipping_province_field">
                            <label for="shipping_province" class="col-sm-6 control-label">
                                <span class="grey">Provincia:</span>
                            </label>
                            <div class="col-sm-9"> <input type="text" class="form-control " value="{{ Auth::user()->shipping_province }}" placeholder="" name="shipping_province" id="shipping_province"> </div>
                        </div>

                        <div class="form-group address-field validate-required validate-postcode" id="shipping_cap_field">
                            <label for="shipping_cap" class="col-sm-6 control-label">
                                <span class="grey">CAP:</span>
                            </label>
                            <div class="col-sm-9"> <input type="number" class="form-control " name="shipping_cap" id="shipping_cap" placeholder="" value="{{ Auth::user()->shipping_cap }}"> </div>
                        </div>

                        <div class="form-group validate-required validate-phone" id="shipping_phone_field">
                            <label for="shipping_phone" class="col-sm-6 control-label">
                                <span class="grey">Telefono:</span>
                            </label>
                            <div class="col-sm-9"> <input type="text" class="form-control " name="shipping_phone" id="shipping_phone" placeholder="" value="{{ Auth::user()->shipping_phone }}"> </div>
                        </div>

                    </div>
                </form>
            </div>

            <!--eof .col-sm-8 (main content)-->
            <!-- sidebar -->
            <aside class="col-sm-5 col-md-4 col-lg-4">
                <h3 class="widget-title" id="order_review_heading">Il tuo ordine</h3>
                <div id="order_review" class="shop-checkout-review-order">
                    <table class="table shop_table shop-checkout-review-order-table">
                        <thead>
                        <tr>
                            <td class="product-name">Prodotto</td>
                            <td class="product-total">Totale</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( Cart::content() as $item)
                            <tr class="cart_item">
                                <td class="product-name"> <a href="{{ route('shop.show', [
                                                        'category1' => str_slug($item->model->category1),
                                                        'category2' => str_slug($item->model->category2),
                                                        'product' => str_slug($item->model->slug)
                                                        ]) }}">{{ $item->name }}</a> <span class="product-quantity">× {{ $item->qty }}</span> </td>
                                <td class="product-total"> <span class="amount grey">€{{ $item->subtotal }}</span> </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="cart-subtotal">
                            <td>Subtotale:</td>
                            <td> <span class="amount grey"><span class="currencies">€</span><span class="amount">{{ Cart::subtotal() }}</span></span> </td>
                        </tr>
                        <tr class="shipping">
                            <td>Spedizione:</td>
                            <td>
                                    <span class="grey">
                                        €{{ $shipping }}
                                    </span>
                            </td>
                        </tr>
                        <tr class="order-total">
                            <td>Totale:</td>
                            <td>
                                    <span class="amount grey">
                                        <strong>
                                            <span class="currencies">€</span>
                                            <span class="amount">
                                                {{ Cart::subtotal() + $shipping}}
                                            </span>
                                        </strong>
                                    </span>
                            </td>
                        </tr>
                        <tr class="order-total">
                            <td>IVA (22%):</td>
                            <td>
                                    <span class="amount grey">
                                        <strong>
                                            <span class="currencies">€</span>
                                            <span class="amount">
                                                {{ Cart::tax()}}
                                            </span>
                                        </strong>
                                    </span>
                            </td>
                        </tr>
                        <tr class="order-total">
                            <td>Total:</td>
                            <td>
                                    <span class="amount grey">
                                        <strong>
                                            <span class="currencies">€</span>
                                            <span class="amount">
                                                {{ Cart::total() + $shipping}}
                                            </span>
                                        </strong>
                                    </span>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <div id="payment" class="shop-checkout-payment">
                        <h3 class="widget-title">Pagamento</h3>
                        <ul class="list1 no-bullets payment_methods methods">
                            <li class="payment_method_bacs">
                                <div class="radio"> <label for="payment_method_bacs">
                                        <input id="payment_method_bacs" type="radio" name="payment_method" value="bacs" checked="checked">
                                        <span class="grey">Bonifico Bancario</span>
                                    </label> </div>
                                <div class="payment_box payment_method_bacs">
                                    <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                </div>
                            </li>
                            <!--
                            <li class="payment_method_cheque">
                                <div class="radio"> <label for="payment_method_cheque">
                                        <input id="payment_method_cheque" type="radio" name="payment_method" value="cheque">
                                        <span class="grey">Cheque Payment</span>
                                    </label> </div>
                            </li>
                            <li class="payment_method_paypal">
                                <div class="radio"> <label for="payment_method_paypal">
                                        <input id="payment_method_paypal" type="radio" name="payment_method" value="paypal">
                                        <span class="grey">PayPal</span>

                                    </label> </div>
                            </li>
                            -->
                            <li class="payment_method_paypal">
                                <div class="radio"> <label for="payment_method_stripe">
                                        <input id="payment_method_stripe" type="radio" name="payment_method" value="stripe">
                                        <span class="grey">Carta di credito</span>

                                    </label> </div>
                            </li>
                        </ul>
                        <br>

                        <div class="place-order">
                            <button class="btn btn-outline-primary" name="checkout_place_order" id="place_order" value="Place order"> Effettua l'ordine </button>
                        </div>
                    </div>
                </div>
            </aside>
            <!-- eof aside sidebar -->
        </div>
    </div>

@endsection

@section('extra-js')
    <script>
        $(document).ready(function() {

            $('.form-stripe').hide();

            $('input[type="radio"]').click(function() {
                if($(this).attr('id') == 'payment_method_stripe') {
                    $('.form-stripe').show();
                }

                else {
                    $('.form-stripe').hide();
                }
            });

            // Create a Stripe client.
            var stripe = Stripe('pk_test_HLaVb62hZOD8jU987wlb7GmR');

            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontFamily: '"Raleway", sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style,
                hidecap: true
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');

            $("#place_order").click( function(event) {
                event.preventDefault();

                if ($("#payment_method_stripe").is(':checked')) {
                    // Disable submit button
                    document.getElementById('place_order').disabled = true;

                    var options = {
                        name: document.getElementById('name_on_card').value,
                        address_line1: document.getElementById('address').value,
                        address_city: document.getElementById('city').value,
                        address_state: document.getElementById('province').value,
                        address_zip: document.getElementById('cap').value
                    };

                    stripe.createToken(card, options).then(function (result) {
                        if (result.error) {
                            // Inform the user if there was an error.
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;

                            // Enable submit button
                            document.getElementById('place_order').disabled = false;

                        } else {
                            // Send the token to your server.
                            stripeTokenHandler(result.token);
                        }
                    });
                }

                else {
                    var hiddenInputGateway = document.createElement('input');
                    hiddenInputGateway.setAttribute('type', 'hidden');
                    hiddenInputGateway.setAttribute('name', 'payment_method');
                    hiddenInputGateway.setAttribute('value', 'bacs');
                    form.appendChild(hiddenInputGateway);
                    // Submit the form
                    form.submit();
                }


            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                var hiddenInputGateway = document.createElement('input');
                hiddenInputGateway.setAttribute('type', 'hidden');
                hiddenInputGateway.setAttribute('name', 'payment_method');
                hiddenInputGateway.setAttribute('value', 'stripe');
                form.appendChild(hiddenInputGateway);

                // Submit the form
                document.getElementById('payment-form').submit();
            }
        });
    </script>
@endsection