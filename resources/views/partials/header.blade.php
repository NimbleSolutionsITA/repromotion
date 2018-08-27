<!-- header section -->
<header class="xs-header">
    <!-- nav bar section -->
    <div class="xs-navBar">
        <div class="container">
            <div class="row" style="align-items: center; justify-content: center;">
                <div class="col-lg-3 col-sm-4 xs-order-1">
                    <div class="xs-logo-wraper">
                        <a href="/">
                            <img src="/images/logo_v3.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-sm-3 xs-order-3 xs-menus-group">
                    <h3 style="color: #cccbcb; text-align: center;">Catalogo di gadget personalizzati e merchandising a marchio <img style="height: 20px; margin: 0 0 3px 10px;" src="/images/remax-mini.png"> </h3>
                </div>
                <div class="col-lg-1 col-sm-5 xs-order-2 xs-wishlist-group">
                    <div class="xs-wish-list-item">
                        <!--
                        <span class="xs-wish-list">
                            <a href="#" class="xs-single-wishList">
                                <span class="xs-item-count">0</span>
                                <i class="icon icon-heart"></i>
                            </a>
                        </span>
                        -->
                        <div class="dropdown dropright xs-miniCart-dropdown">
                            <a href="#" class="dropdown-toggle xs-single-wishList" data-toggle="dropdown" aria-expanded="false">
                                <span class="xs-item-count highlight">{{ Cart::instance('default')->count() }}</span>
                                <i class="icon icon-bag"></i>
                            </a>
                            <ul class="dropdown-menu fadeIns xs-miniCart-menu">
                                @foreach(Cart::instance('default')->content() as $row)
                                    <li class="mini_cart_item media">
                                        <a class="d-flex mini-product-thumb" href="{{ route('shop.show', [
                                                        'category1' => str_slug($row->model->category1),
                                                        'category2' => str_slug($row->model->category2),
                                                        'product' => str_slug($row->model->slug)
                                                        ]) }}">
                                            <img src="http://images.midoceanbrands.com/image.mvc/WithIcon/{{ substr(str_replace('-', '_', $row->model->product_number), 0 ,9) }}//180/180/" alt="">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="mini-cart-title"><a href="{{ route('shop.show', [
                                                        'category1' => str_slug($row->model->category1),
                                                        'category2' => str_slug($row->model->category2),
                                                        'product' => str_slug($row->model->slug),
                                                        'color' => str_slug($row->model->color)
                                                        ]) }}">{{ $row->name }}</a></h4>
                                            <span class="quantity">{{ $row->qty }} ×
                                                    <span class="amount">€{{ number_format((float)$row->price, 2, ',', '.') }}</span>
                                                </span>
                                        </div>
                                        <form action="{{ route('cart.destroy', $row->rowId) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn-cancel pull-right" type="submit">x</button>
                                        </form>
                                    </li>
                                @endforeach
                                <li class="mini-cart-btn">
                                    <a class="badge badge-pill badge-primary" href="{{ route('cart.index') }}">Vai al carrello</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- .row END -->
        </div><!-- .container END -->
    </div>    <!-- End nav bar section -->

    <!-- nav down section -->
    <div class="xs-navDown">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 d-none d-md-none d-lg-block">
                    <!-- vertical menu bar -->
                    <div class="cd-dropdown-wrapper xs-vartical-menu">
                        <a class="cd-dropdown-trigger" href="#0">
                            <i class="fa fa-list-ul"></i> Sfoglia Catalogo
                        </a>
                        <nav class="cd-dropdown">
                            <h2>Categorie</h2>
                            <a href="#0" class="cd-close">Chiudi</a>
                            <ul class="cd-dropdown-content">

                                @foreach($categories->unique('category1') as $category1)

                                    <li class="has-children">
                                        <a @if ($loop->first) class="no-padding" @endif href="/shop/{{ str_slug($category1->category1) }}">
                                            <i class="icon {{ $category1->catIcon() }}"></i>{{ ucfirst(strtolower($category1->category1)) }}
                                            <i class="fa fa-angle-right submenu-icon"></i>
                                        </a>
                                        <ul class="cd-secondary-dropdown is-hidden">
                                            <li class="go-back"><a href="#0">Menu</a></li>
                                            <li class="has-children">
                                                <ul class="is-hidden">
                                                    <li style="border-bottom:1px solid black; font-size: 1.2em; margin-bottom: 10px;"><a style="font-weight: 900" href="/shop/{{ str_slug($category1->category1) }}">{{ ucfirst(strtolower($category1->category1)) }}</a></li>
                                                    @foreach($categories->where('category1', '=', $category1->category1)->unique('category2') as $category2)
                                                        <li><a href="/shop/{{ str_slug($category1->category1) }}/{{ str_slug($category2->category2) }}">{{ ucfirst(strtolower($category2->category2)) }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                        </ul> <!-- .cd-secondary-dropdown -->
                                    </li> <!-- .has-children -->

                                @endforeach

                            </ul> <!-- .cd-dropdown-content -->
                        </nav> <!-- .cd-dropdown -->
                    </div> <!-- .cd-dropdown-wrapper -->                <!-- End vertical menu bar -->
                </div>
                <div class="col-lg-9">
                    <form class="xs-navbar-search" method="get"  action="{{ route('shop') }}">
                        <div class="input-group">
                            <input type="text" value="" name="keyword" class="form-control" placeholder="Cerca il tuo prodotto">
                            <div class="input-group-btn">
                                <input type="hidden" id="search-param" name="post_type" value="product">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- .row END -->
        </div><!-- .container END -->
    </div>    <!-- End nav down section -->

    <!-- <div class="nav-cover"></div> -->
</header>
<!-- End header section -->