@extends('layouts.app')

@section('title', $title)

@section('content')
    <!--breadcumb start here-->
    <div class="xs-breadcumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"> Home</a></li>
                    <li class="breadcrumb-item"><a href="/shop">Shop </a></li>
                    @if(Request::segment(2))<li class="breadcrumb-item"><a href="/shop/{{ Request::segment(2) }}">{{ ucwords(str_replace('-', ' ', Request::segment(2))) }} </a></li>@endif
                    @if(Request::segment(3))<li class="breadcrumb-item"><a href="/shop/{{ Request::segment(2) }}/{{ Request::segment(3) }}">{{ ucwords(str_replace('-', ' ', Request::segment(3))) }} </a></li>@endif
                </ol>
            </nav>
        </div>
    </div>
    <!--breadcumb end here--><!-- End welcome section -->

    <!-- shop section -->
    <section class="xs-section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <!-- shop sidebar -->
                    <div class="shop-category">
                        <div class="widget widget_range">
                            <div class="price_label media">
                                <form method="GET"  action="{{ route('shop', [
                                                    'category1' => str_slug($currentCat1),
                                                    'category2' => str_slug($currentCat2)
                                                ]) }}">
                                    <label for="amount">Prezzo:</label>
                                    <button type="submit" style="background: transparent; border: none; color: #117aff; float: right;"><i class="fa fa-refresh"></i></button>
                                    <input type="text" id="amount" name="amount" readonly>
                                </form>
                            </div>
                            <div id="slider-range"></div>
                        </div><!-- .widget .widget_range END -->

                        <div class="widget widget_cate">
                            <form method="GET"  action="{{ route('shop') }}" class="shop_cate_form">
                                <button type="submit" style="background: transparent; border: none; color: #117aff; float: right;"><i class="fa fa-refresh"></i></button>
                                <h5 class="widget-title">Categorie</h5>
                                @foreach($categories->unique('category1') as $category)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="{{ $category->category1 }}" id="{{ $category->category1 }}" name="input_category[]"  @if( in_array($category->category1, $selectedCat) ) checked @endif>
                                        <label class="custom-control-label" for="{{ $category->category1 }}">{{ $category->category1 }}</label>
                                    </div><!-- .custom-control custom-checkbox END -->
                                @endforeach
                            </form>
                        </div><!-- .widget .widget_cate END -->

                        <!-- .widget .widget_cate END -->
                        <div class="widget widget_banner">
                            <img src="assets/images/image_loader.gif" data-echo="assets/images/web_banner/shop_offer_banner.png" alt="">
                        </div><!-- .widget .widget_banner END -->
                    </div>                <!-- End shop sidebar -->
                </div>
                <div class="col-md-9 col-lg-9">
                    <div class="shop-cate-list">
                        <form method="GET"  action="{{ route('shop', [
                                                    'category1' => str_slug($currentCat1),
                                                    'category2' => str_slug($currentCat2)
                                                ]) }}">
                            <div class="shop-cate-title">
                                <h5><img style="height: 20px; margin: 0 0 3px 10px;" src="/images/remax-mini.png" class=""></h5>
                            </div>
                            <ul class="shop-catelist-item">
                                <li>
                                    <div class="media">
                                        <h6 class="d-flex">Colore</h6>
                                        <div class="media-body">
                                            <div class="custom-control custom-radio color-one">
                                                <input onchange="this.form.submit()" type="radio" id="color_one" value='verde' name="color" class="custom-control-input" {{ request('color') == 'verde' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_one"></label>
                                            </div>
                                            <div class="custom-control custom-radio color-two">
                                                <input onchange="this.form.submit()" type="radio" id="color_two" value='blu' name="color" class="custom-control-input" {{ request('color') == 'blu' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_two"></label>
                                            </div>
                                            <div class="custom-control custom-radio color-three">
                                                <input onchange="this.form.submit()" type="radio" id="color_three" value='grigio' name="color" class="custom-control-input" {{ request('color') == 'grigio' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_three"></label>
                                            </div>
                                            <div class="custom-control custom-radio color-four">
                                                <input onchange="this.form.submit()" type="radio" id="color_four" value='rosso' name="color" class="custom-control-input" {{ request('color') == 'rosso' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_four"></label>
                                            </div>
                                            <div class="custom-control custom-radio color-five">
                                                <input onchange="this.form.submit()" type="radio" id="color_five" value='arancio' name="color" class="custom-control-input" {{ request('color') == 'arancio' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_five"></label>
                                            </div>
                                            <div class="custom-control custom-radio color-six">
                                                <input onchange="this.form.submit()" type="radio" id="color_six" value='nero' name="color" class="custom-control-input" {{ request('color') == 'nero' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_six"></label>
                                            </div>
                                            <div class="custom-control custom-radio color-seven">
                                                <input onchange="this.form.submit()" type="radio" id="color_seven" value='giallo' name="color" class="custom-control-input" {{ request('color') == 'giallo' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_seven"></label>
                                            </div>
                                            <div class="custom-control custom-radio color-eight">
                                                <input onchange="this.form.submit()" type="radio" id="color_eight" value='bianco' name="color" class="custom-control-input" {{ request('color') == 'bianco' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_eight"></label>
                                            </div>
                                            <div class="custom-control custom-radio color-nine">
                                                <input onchange="this.form.submit()" type="radio" id="color_nine" value='altro' name="color" class="custom-control-input" {{ request('color') == 'altro' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="color_nine"></label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!--
                                <li>53085     4969 4786 8918 0
                                    <div class="media">
                                        <h6 class="d-flex">View</h6>
                                        <ul class="nav nav-tabs shop-view-nav" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="list-th-tab" data-toggle="tab" href="#list-th" role="tab" aria-controls="list-th" aria-selected="true"><i class="fa fa-th"></i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="list-small-tab" data-toggle="tab" href="#listSmall" role="tab" aria-controls="listSmall" aria-selected="false"><i class="fa fa-th-list"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                -->
                                <li>
                                    <select onchange="this.form.submit()" aria-required="true" id="sort" name="sort" class="product-ordering">
                                        <option value="" disabled selected data-default>Ordinamento</option>
                                        <option {{ request('sort') == 'pra' ? 'selected' : '' }} value="pra">per Prezzo asc</option>
                                        <option {{ request('sort') == 'prd' ? 'selected' : '' }} value="prd">per Prezzo dsc</option>
                                        <option {{ request('sort') == 'naa' ? 'selected' : '' }} value="naa">per Nome asc</option>
                                        <option {{ request('sort') == 'nad' ? 'selected' : '' }} value="nad">per Nome dsc</option>
                                    </select>
                                </li>
                            </ul>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="list-th" role="tabpanel" aria-labelledby="list-th-tab">
                            <div class="row category-v4">

                                @foreach ($products as $product)
                                    <div class="col-md-4">
                                        <div class="xs-product-wraper">
                                            <img src="{{ $product->getImageLinkAttribute(253, 189) }}" alt="{{$product->name}}">
                                            <div class="xs-product-content">
                                            <span class="product-categories">
                                                <a href="{{ route('shop', [
                                                    'category1' => str_slug($product->category1),
                                                    'category2' => str_slug($product->category2)
                                                ]) }}" rel="tag">{{ $product->category2 }}</a>
                                            </span>
                                                <h4 class="product-title">
                                                    <a href="{{ route('shop.show', [
                                                        'category1' => str_slug($product->category1),
                                                        'category2' => str_slug($product->category2),
                                                        'product' => str_slug($product->slug)
                                                        ]) }}">
                                                        {{ ucfirst(strtolower($product->name)) }}
                                                    </a>
                                                </h4>
                                                <span class="price version-2">
                                                €{{ $product->start_price }}
                                            </span>
                                            </div><!-- .xs-product-content END -->
                                        </div>
                                    </div>
                                @endforeach

                            </div><!-- .row END -->
                        </div>
                        {{ $products->appends(Request::except('page'))->links() }}
                    </div>
                </div>
            </div><!-- .row END -->
        </div><!-- .container END -->
    </section>

    <style>
        .widget_range .ui-state-default, .widget_range .ui-widget-content .ui-state-default, .widget_range .ui-slider .ui-slider-range {
            background-color: #117aff;
        }
    </style>

@endsection
