@extends('layouts.app')

@section('content')

    <!-- banner section -->
    <div class="xs-banner">
        <div class="container">
            <div class="row">
                @include('partials.home_slider')
                <div class="col-lg-4">
                    <div class="xs-feature-product">
                        <div class="remax-banner">
                            <h6>I migliori gadget Remax a portata di click!</h6>
                            <p>Aurora Promotion, grazie alla sua trentennale esperienza nel campo dei gadget promozionali è stato nominato fornitore ufficiale Remax. Sfoglia il catalogo a te dedicato, abbiamo prodotti origininali e utili per farti voler bene dai tuoi clienti attuali e futuri</p>
                            <img src="/images/logo_v3.png" style="margin-right: 5%;">
                            <img src="/images/remax-approved-supplier.png">
                        </div>
                    </div><!-- .xs-feature-product END -->
                    <div class="xs-feature-product">
                        <img src="/images/banner-right.jpg">
                    </div><!-- .xs-feature-product END -->
                </div>
            </div><!-- .row END -->
        </div><!-- .container END -->
    </div><!-- End banner section -->

    <div class="container">
        <div class="row new-arrivals">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-text">
                        <span>Nuovi arrivi</span>
                        <h5>Chiavette USB ultima generazione</h5>
                        <a href="/shop/ufficio/accessori-computer"><button class="btn btn-outline">Vedi tutti</button></a>
                    </div>
                    <img src="/images/products/700x700/MO1001_37.jpg">
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="box-text">
                        <span>Nuovi arrivi</span>
                        <h5>Coffee mug in diversi colori</h5>
                        <a href="/shop/casa-vivere/ambiente"><button class="btn btn-outline">Vedi tutti</button></a>
                    </div>
                    <img src="/images/products/700x700/MO9245_04.jpg">
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="box-text">
                        <span>Nuovi arrivi</span>
                        <h5>Zainetto 20lt in vari colori</h5>
                        <a href="/shop/borse-viaggi/zaino"><button class="btn btn-outline">Vedi tutti</button></a>
                    </div>
                    <img src="/images/products/700x700/KC2364_05.jpg">
                </div>
            </div>
        </div>
    </div>

    <!-- today gadget version 2 section -->
    <div class="xs-section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="xs-content-header">
                        <h2 class="xs-content-title">I più venduti</h2>
                        <ul class="nav nav-tabs xs-nav-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="selled-abbigliametno-tab" data-toggle="tab" href="#selled-abbigliametno" role="tab" aria-controls="selled-abbigliametno" aria-selected="true">Abbigliamento</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="selled-borse-tab" data-toggle="tab" href="#selled-borse" role="tab" aria-controls="selled-borse" aria-selected="false">Borse & Viaggi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="selled-casa-tab" data-toggle="tab" href="#selled-casa" role="tab" aria-controls="selled-casa" aria-selected="false">Casa & Vivere</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="selled-ufficio-tab" data-toggle="tab" href="#selled-ufficio" role="tab" aria-controls="selled-ufficio" aria-selected="false">Ufficio</a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="selled-abbigliametno" role="tabpanel" aria-labelledby="selled-abbigliametno-tab">
                            <div class="row">

                                @foreach($abbigliamento as $itemA)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="xs-product-wraper version-3 text-center">
                                            <img src="/images/image_loader.gif" data-echo="{{ $itemA->getImageLinkAttribute(253, 189) }}" alt="Lamp">
                                            <div class="xs-product-content">
                                            <span class="product-categories">
                                                <a href="{{ route('shop', [
                                                    'category1' => str_slug($itemA->category1)
                                                ]) }}" rel="tag">{{ $itemA->category1 }}</a>
                                            </span>
                                                <h4 class="product-title"><a href="{{ route('shop.show', [
                                                        'category1' => str_slug($itemA->category1),
                                                        'category2' => str_slug($itemA->category2),
                                                        'product' => str_slug($itemA->slug)
                                                        ]) }}">{{ $itemA->name }}</a></h4>
                                                <span class="price">
                                                €{{ $itemA->start_price }}
                                            </span>
                                            </div><!-- .xs-product-content END -->
                                            <!-- <div class="xs-overlay bg-black"></div> -->
                                        </div><!-- .xs-product-wraper .version-3 END -->
                                    </div>
                                @endforeach

                            </div>
                        </div><!-- #today-onSale END -->
                        <div class="tab-pane fade" id="selled-borse" role="tabpanel" aria-labelledby="selled-borse-tab">
                            <div class="row">

                                @foreach($viaggi as $itemV)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="xs-product-wraper version-3 text-center">
                                            <img src="/images/image_loader.gif" data-echo="{{ $itemV->getImageLinkAttribute(253, 189) }}" alt="Lamp">
                                            <div class="xs-product-content">
                                            <span class="product-categories">
                                                <a href="{{ route('shop', [
                                                    'category1' => str_slug($itemV->category1)
                                                ]) }}" rel="tag">{{ $itemV->category1 }}</a>
                                            </span>
                                                <h4 class="product-title"><a href="{{ route('shop.show', [
                                                        'category1' => str_slug($itemV->category1),
                                                        'category2' => str_slug($itemV->category2),
                                                        'product' => str_slug($itemV->slug)
                                                        ]) }}">{{ $itemV->name }}</a></h4>
                                                <span class="price">
                                                €{{ $itemV->start_price }}
                                            </span>
                                            </div><!-- .xs-product-content END -->
                                            <!-- <div class="xs-overlay bg-black"></div> -->
                                        </div><!-- .xs-product-wraper .version-3 END -->
                                    </div>
                                @endforeach

                            </div>
                        </div><!-- #today-hot-sale END -->
                        <div class="tab-pane fade" id="selled-casa" role="tabpanel" aria-labelledby="selled-casa-tab">
                            <div class="row">

                                @foreach($casa as $itemC)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="xs-product-wraper version-3 text-center">
                                            <img src="/images/image_loader.gif" data-echo="{{ $itemC->getImageLinkAttribute(253, 189) }}" alt="Lamp">
                                            <div class="xs-product-content">
                                            <span class="product-categories">
                                                <a href="{{ route('shop', [
                                                    'category1' => str_slug($itemC->category1)
                                                ]) }}" rel="tag">{{ $itemC->category1 }}</a>
                                            </span>
                                                <h4 class="product-title"><a href="{{ route('shop.show', [
                                                        'category1' => str_slug($itemC->category1),
                                                        'category2' => str_slug($itemC->category2),
                                                        'product' => str_slug($itemC->slug)
                                                        ]) }}">{{ $itemC->name }}</a></h4>
                                                <span class="price">
                                                €{{ $itemC->start_price }}
                                            </span>
                                            </div><!-- .xs-product-content END -->
                                            <!-- <div class="xs-overlay bg-black"></div> -->
                                        </div><!-- .xs-product-wraper .version-3 END -->
                                    </div>
                                @endforeach

                            </div>
                        </div><!-- #today-trend END -->
                        <div class="tab-pane fade" id="selled-ufficio" role="tabpanel" aria-labelledby="selled-ufficio-tab">
                            <div class="row">

                                @foreach($ufficio as $itemU)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="xs-product-wraper version-3 text-center">
                                            <img src="/images/image_loader.gif" data-echo="{{ $itemU->getImageLinkAttribute(253, 189) }}" alt="Lamp">
                                            <div class="xs-product-content">
                                            <span class="product-categories">
                                                <a href="{{ route('shop', [
                                                    'category1' => str_slug($itemU->category1)
                                                ]) }}" rel="tag">{{ $itemU->category1 }}</a>
                                            </span>
                                                <h4 class="product-title"><a href="{{ route('shop.show', [
                                                        'category1' => str_slug($itemU->category1),
                                                        'category2' => str_slug($itemU->category2),
                                                        'product' => str_slug($itemU->slug)
                                                        ]) }}">{{ $itemU->name }}</a></h4>
                                                <span class="price">
                                                €{{ $itemU->start_price }}
                                            </span>
                                            </div><!-- .xs-product-content END -->
                                            <!-- <div class="xs-overlay bg-black"></div> -->
                                        </div><!-- .xs-product-wraper .version-3 END -->
                                    </div>
                                @endforeach

                            </div>
                        </div><!-- #today-best-sale END -->
                    </div>
                </div>
            </div>
        </div><!-- .container END -->
    </div>

    <div class="row hero-unit">
        <div class="container">
            <h1>ORDINI PERSONALIZZATI?</h1>
            <h1>RICHIESTE PARTICOLARI?</h1>
            <a  href="mailto:info@aurorapromotion.it."><button class="btn btn-danger">CONTATTACI</button></a>
            <h2>Possiamo ralizzare qualsiasi idea creativa!</h2>
        </div>
    </div>

@endsection

@section('extra-css')
    <style>
        h3.xs-banner-title {
            color: white;
        }
        .xs-btn-wraper {
            display: block;
        }
        .xs-banner .xs-feature-product .remax-banner {
            padding: 15px;
            border: 2px solid #e7e7e7;
            border-radius: 4px;
        }
        .xs-banner .xs-feature-product .remax-banner h6, .xs-banner .xs-feature-product .remax-banner p {
            color: #444444;
        }
        .xs-banner .xs-feature-product .remax-banner img {
            width: 45%;
            height: auto;
            min-height: auto;
        }
        .xs-banner .xs-feature-product img {
            min-height: auto;
        }
        .xs-banner .btn:not([data-toggle="popover"])::before {
            background-color: #cccbcb;
        }
        .new-arrivals .box{
            padding: 15px;
            border: 2px solid #e7e7e7;
            border-radius: 4px;
            display: inline-block;
        }
        .new-arrivals .box .box-text {
            width: 49%;
            float: left;
        }
        .new-arrivals .box .box-text h5 {
            color: #444444;
            margin: 10px 0 15px;
            min-height: 72px;
        }
        .new-arrivals .box .box-text span {
            color: #cccbcb;
            font-size: 1.2em;
        }
        .new-arrivals .box img {
            width: 49%;
            float: right;
        }
        .new-arrivals .box .box-text button.btn.btn-outline {
            background-color: #cccbcb;
            padding: 10px 40px;
        }
        .hero-unit {
            background-color: #cccbcb;
            text-align: center;
            padding: 50px;
        }

        .hero-unit button.btn.btn-danger {
            margin: 25px 0;
            font-size: 1.5em;
        }
        .hero-unit h2 {
            font-weight: lighter;
        }
        .xs-product-wraper {
            border: 2px solid #e7e7e7;
            border-radius: 4px;
        }
    </style>
@endsection