@extends('layouts.app')

@section('title', $product->first()->name)

@section('extra-css')
    <style>
        span, td, p {
            color: #333e48;
        }
        .alt {
            background-color: #f5f5f5;
        }
    </style>
@endsection

@section('content')

    <!-- welcome section -->
    <!--breadcumb start here-->
    <div class="xs-breadcumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"> Home</a></li>
                    <li class="breadcrumb-item"><a href="/shop">Shop </a></li>
                    <li class="breadcrumb-item"><a href="/shop/{{ Request::segment(2) }}">{{ ucwords(str_replace('-', ' ', Request::segment(2))) }} </a></li>
                    <li class="breadcrumb-item"><a href="/shop/{{ Request::segment(2) }}/{{ Request::segment(3) }}">{{ ucwords(str_replace('-', ' ', Request::segment(3))) }} </a></li>
                    <li class="breadcrumb-item"><a href="#">{{ ucwords(str_replace('-', ' ', Request::segment(4))) }} </a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!--breadcumb end here--><!-- End welcome section -->

    <!-- product info section -->
    <!-- Modal -->
    <div class="xs-section-padding xs-product-details-section">
        <div class="container">
            @include('partials.messages')
            <div class="row">
                <div class="col-lg-6">
                    <div class="xs-sync-slider-preview">
                        <div class="sync-slider-preview owl-carousel">
                            <div class="item">
                                <img src="{{ $product->first()->getImageLinkAttribute(700, 700) }}" alt="{{$product->first()->name}}">
                            </div>
                            <div class="item">
                                <img src="{{ $product->first()->getImageLinkAttribute(700, 700, 'a') }}" alt="{{$product->first()->name}}">
                            </div>
                            <div class="item">
                                <img src="{{ $product->first()->getImageLinkAttribute(700, 700, 'b') }}" alt="{{$product->first()->name}}">
                            </div>
                        </div>
                    </div>
                    <div class="sync-slider-thumb owl-carousel">
                        <div class="item">
                            <img src="{{ $product->first()->getImageLinkAttribute(160, 96) }}" alt="{{$product->first()->name}}">
                        </div>
                        <div class="item">
                            <img src="{{ $product->first()->getImageLinkAttribute(160, 96, 'a') }}" alt="{{$product->first()->name}}">
                        </div>
                        <div class="item">
                            <img src="{{ $product->first()->getImageLinkAttribute(160, 96, 'b') }}" alt="{{$product->first()->name}}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="summary-content single-product-summary">
                        <h3 class="entry-title">{{ $product->first()->short_description }}</h3>
                        <h4 class="product-title">{{ $product->first()->name }}</h4>
                        </span>
                        <p>{{ $product->first()->long_description }}</p>
                        <ul class="xs-list check">
                            <li>Colore: {{ $product->first()->color }}</li>
                            <li>Materiale: {{ $product->first()->material_type }}</li>
                            <li>Dimensioni: {{ $product->first()->dimensions }}</li>
                            <li>Ordine minimo: {{ $product->first()->min }}</li>
                        </ul>
                        <span class="price highlight">
                        € {{  number_format(($product->first()->getFinalPrice($qty)/$qty), 2, '.', ',') }} <i style="font-size: .4em;">per articolo iva esclusa per ordine di {{ $qty }} pezzi</i>
                    </span>
                        @php $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL', '5XL']; @endphp
                        <form action="{{ route('cart.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->first()->product_base }}">
                            <input type="hidden" name="color" value="{{ $product->first()->color }}">
                            <input type="hidden" name="position" value="{{ $product->first()->position }}">
                            <input type="hidden" name="print_model" value="{{ $product->first()->print_model }}">

                            <div class="xs-add-to-chart-form row">
                                <div class="@if($product->first()->size == '') col-md-8 @else col-md-12 @endif">
                                    @if($product->first()->size == '')
                                        @foreach($sizes as $size)
                                            <input type="hidden" name="qty_{{ $size }}" value="0" />
                                        @endforeach
                                        <div class="w-quantity quantity xs_input_number">
                                            <input type="number" name="qty_U" min="{{ $product->first()->min }}" max="{{ $product->first()->getStockQuantity() }}" value="{{ old('qty_U') ? : $product->first()->min }}" />
                                        </div>
                                        <div style="float: right;" class="w-quantity-btn" style="margin-top: 25px;">
                                            <button type="submit" value="updatePriceU" name="addCart" class="single_add_to_cart_button btn btn-primary">
                                                Aggiorna Prezzo
                                            </button>


                                            <button style="margin-top: 25px;" type="submit" value="addCartU" name="addCart" class="single_add_to_cart_button btn btn-primary">
                                                Aggiungi al Carrello
                                            </button>
                                        </div>
                                        <div class="clearfix"></div>
                                    @else
                                        <input type="hidden" name="qty_U" value="0" />

                                        <div class="row">
                                            @foreach($sizes as $size)
                                                <div class="w-quantity quantity xs_input_number" style="margin: 15px 10px 15px 0;">
                                                    <p style="position: absolute; top: -24px; left: 57px; @if(!$product->where('size', '=', $size)->first()) color:lightgrey; @endif ">{{ $size }}</p>
                                                    <input type="number" name="qty_{{ $size }}"
                                                           @if($product->where('size', '=', $size)->first())
                                                                min="0" max="{{ $product->where('size', '=', $size)->first()->getStockQuantity() }}"
                                                           @else disabled @endif value="{{ old('qty_'.$size) }}"
                                                    />
                                                    @if(!$product->where('size', '=', $size)->first())
                                                        <input type="hidden" name="qty_U" value="0" />
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                @if(!$product->first()->size == '')
                                    <div class="col-md-12" style="float: right;">
                                        <div class="w-quantity-btn">
                                            <button type="submit" value="updatePrice" name="addCart" class="single_add_to_cart_button btn btn-primary">
                                                Aggiorna Prezzo
                                            </button>

                                            <button type="submit" value="addCart" name="addCart" class="single_add_to_cart_button btn btn-primary">
                                                Aggiungi al Carrello
                                            </button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                @endif
                                <!--
                                <div class="col-md-2">
                                    <a href="#" class="xs-wishlist-and-compare"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-2">
                                    <a href="#" class="xs-wishlist-and-compare"><i class="icon icon-shuffle-arrow" aria-hidden="true"></i></a>
                                </div>
                                -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end product info section -->

    <!-- product details section -->
    <div class="xs-section-padding-bottom">
        <div class="container">
            <ul class="nav nav-tabs xs-nav-tab version-4" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="descrizione-tab" data-toggle="tab" href="#descrizione" role="tab" aria-controls="home" aria-selected="true">Descrizione</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="stampa-tab" data-toggle="tab" href="#stampa" role="tab" aria-controls="profile" aria-selected="false">Stampa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="prezzi-tab" data-toggle="tab" href="#prezzi" role="tab" aria-controls="contact" aria-selected="false">Prezzi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="stock-tab" data-toggle="tab" href="#stock" role="tab" aria-controls="contact" aria-selected="false">Stock</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane animated slideInUp show active" id="descrizione" role="tabpanel" aria-labelledby="home-tab">
                    <p>{{ $product->first()->long_description }}</p>
                    <ul class="list-group list-group-flush table">
                        <li class="list-group-item clearfix">
                            <div class="float-left w-50">
                                Nome: <span>{{ $product->first()->name }}</span>
                            </div>
                            <div class="float-right w-50">
                                Dimensioni: <span>{{ $product->first()->dimensions }}</span>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="float-left w-50">
                                Colore: <span>{{ $product->first()->color }}</span>
                            </div>
                            <div class="float-right w-50">
                                Materiale: <span>{{ $product->first()->material_type }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane animated slideInUp" id="stampa" role="tabpanel" aria-labelledby="profile-tab">
                    @foreach($printinfos->where('min_qty', 1) as $printinfo)
                        <ul class="list-group list-group-flush table" style="border-bottom: 1px solid lightgrey; margin-bottom: 20px;">
                            <li class="list-group-item clearfix">
                                <div class="float-left w-50">
                                    Posizione: <span>{{ $printinfo->printing_position }}</span>
                                </div>
                                <div class="float-right w-50">
                                    Tecnica di stampa: <span>{{ $printinfo->printing_technique_description }}</span>
                                </div>
                            </li>
                            <li class="list-group-item clearfix">
                                @if ($printinfo->area > 0)
                                    <div class="float-left w-50">
                                        Area di stampa: <span>{{ $printinfo->area/100 }} cm2</span>
                                    </div>
                                @endif
                                @if ($printinfo->number_of_colours > 0)
                                    <div class="float-right w-50">
                                        Numero di colori: <span>{{ $printinfo->number_of_colours }}</span>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    @endforeach
                </div>
                <div class="tab-pane animated slideInUp" id="prezzi" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Quantità</th>
                                <th scope="col">{{ $product->first()->min }}</th>
                                <th scope="col">50+</th>
                                <th scope="col">100+</th>
                                <th scope="col">250+</th>
                                <th scope="col">500+</th>
                                <th scope="col">1.000+</th>
                                <th scope="col">2.500+</th>
                                <th scope="col">5.000+</th>
                                <th scope="col">10.000+</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row"><b>Prezzo per articolo</b></td>
                                <td>{{ number_format(($product->first()->start_price), 2, '.', ',') }}€</td>
                                <td>{{ number_format(($product->first()->getFinalPrice(50)/50), 2, '.', ',') }}€</td>
                                <td>{{ number_format(($product->first()->getFinalPrice(100)/100), 2, '.', ',') }}€</td>
                                <td>{{ number_format(($product->first()->getFinalPrice(250)/250), 2, '.', ',') }}€</td>
                                <td>{{ number_format(($product->first()->getFinalPrice(500)/500), 2, '.', ',') }}€</td>
                                <td>{{ number_format(($product->first()->getFinalPrice(1000)/1000), 2, '.', ',') }}€</td>
                                <td>{{ number_format(($product->first()->getFinalPrice(2500)/2500), 2, '.', ',') }}€</td>
                                <td>{{ number_format(($product->first()->getFinalPrice(5000)/5000), 2, '.', ',') }}€</td>
                                <td>{{ number_format(($product->first()->getFinalPrice(10000)/10000), 2, '.', ',') }}€</td>
                            </tr>
                            <tr>
                                <td scope="row"><b>Risparmi</b></td>
                                <td>-</td>
                                <td>{{ number_format(100 * ($product->first()->start_price - $product->first()->getFinalPrice(50)/50) / $product->first()->start_price, 2, '.', ',') }}%</td>
                                <td>{{ number_format(100 * ($product->first()->start_price - $product->first()->getFinalPrice(100)/100) / $product->first()->start_price, 2, '.', ',') }}%</td>
                                <td>{{ number_format(100 * ($product->first()->start_price - $product->first()->getFinalPrice(250)/250) / $product->first()->start_price, 2, '.', ',') }}%</td>
                                <td>{{ number_format(100 * ($product->first()->start_price - $product->first()->getFinalPrice(500)/500) / $product->first()->start_price, 2, '.', ',') }}%</td>
                                <td>{{ number_format(100 * ($product->first()->start_price - $product->first()->getFinalPrice(1000)/1000) / $product->first()->start_price, 2, '.', ',') }}%</td>
                                <td>{{ number_format(100 * ($product->first()->start_price - $product->first()->getFinalPrice(2500)/2500) / $product->first()->start_price, 2, '.', ',') }}%</td>
                                <td>{{ number_format(100 * ($product->first()->start_price - $product->first()->getFinalPrice(5000)/5000) / $product->first()->start_price, 2, '.', ',') }}%</td>
                                <td>{{ number_format(100 * ($product->first()->start_price - $product->first()->getFinalPrice(10000)/10000) / $product->first()->start_price, 2, '.', ',') }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane animated slideInUp" id="stock" role="tabpanel" aria-labelledby="stock-tab">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Taglia</th>
                            <th scope="col">Disponibilità</th>
                            <th scope="col">Quantità</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($product as $prod)
                                <tr @if($loop->iteration  % 2 == 0) class="alt" @endif>
                                    <td rowspan="{{ 1 + $prod->arrivals()->count() }}"><b>{{ $prod->size }}</b></td>
                                    <td>Oggi</td>
                                    <td>{{ $prod->stock }} pezzi</td>
                                </tr>
                                @if ($prod->arrivals()->count() > 0)
                                    @foreach($prod->arrivals()->get() as $arrival)
                                        <tr @if($loop->parent->iteration  % 2 == 0) class="alt" @endif>
                                            <td>In arrivo fra {{ str_replace(' da adesso', '', \Carbon\Carbon::parse($arrival->date)->diffForHumans()) }}</td>
                                            <td>{{ $arrival->qty }} pezzi</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- .container END -->
    </div><!-- end product details section -->
@endsection