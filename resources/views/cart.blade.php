@extends('layouts.app')

@section('title', 'Carrello')


@section('extra-css')
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        h4 a {
            color: #333e48;
        }

        .btn:not([data-toggle="popover"]).btn-sm {
            min-width: 40px;
            float: right;
        }
        .btn-info {
            color: #333e48 !important;
            background-color: #cccbcb;
            border-color: #cccbcb;
        }
        .btn-info:hover {
            color: white !important;
        }
        .table>tbody>tr>td, .table>tfoot>tr>td{
            vertical-align: middle;
        }
        table#cart {
            display: table;
            max-width: 100%;
            overflow: scroll;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            table-layout: fixed;
        }

        table#cart thead th:nth-child(1), table#cart tbody td:nth-child(1) {
            width: 50%;
        }

        table#cart thead  th:nth-child(2), table#cart tbody td:nth-child(2){
            width: 10%;
        }

        table#cart thead  th:nth-child(3), table#cart tbody td:nth-child(3){
            width: 18%;
        }

        table#cart thead  th:nth-child(4), table#cart tbody td:nth-child(4), table#cart tfoot  td:nth-child(2){
            width: 22%;
        }

        @media screen and (max-width: 600px) {
            table#cart tbody td .form-control{
                width:20%;
                display: inline !important;
            }
            .actions .btn{
                width:36%;
                margin:1.5em 0;
            }

            .actions .btn-info{
                float:left;
            }
            .actions .btn-danger{
                float:right;
            }

            table#cart thead { display: none; }
            table#cart tbody td { display: block; padding: .6rem; min-width:320px;}
            table#cart tbody tr td:first-child { background: #333; color: #fff; }
            table#cart tbody td:before {
                content: attr(data-th); font-weight: bold;
                display: inline-block; width: 8rem;
            }



            table#cart tfoot td{display:block; text-align: left;}
            table#cart tfoot td strong{display:block; text-align: right;}
            table#cart tfoot td .btn{display:block;}

        }

        span, td, p {
            color: #333e48;
        }

        .btn-outline-primary{
            float: right;
            color: #333e48 !important;
            border-color: #959a9e;
            border-width: 2px;
            padding: 15px 61px;
            margin-right: 15px;
        }

        .btn-outline-primary.shopping{
            float: left;
            background-color: #cccbcb;
            border-color: #cccbcb;
        }

        .btn-outline-primary:hover {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
            color: white !important;
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
                    <li class="breadcrumb-item"><a href="/cart">Cart </a></li>
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
                <div class="col-md-12">
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th>Prodotto</th>
                            <th>Prezzo</th>
                            <th>Quantità</th>
                            <th style="text-align: right!important;" class="text-center">Subtotale</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(Cart::instance('default')->content() as $row)
                            <tr>
                                <td data-th="Prodotto">
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs"><a href="{{ route('shop.show', [
                                                        'category1' => str_slug($row->model->category1),
                                                        'category2' => str_slug($row->model->category2),
                                                        'product' => str_slug($row->model->slug)
                                                        ]) }}"><img src="http://images.midoceanbrands.com/image.mvc/WithIcon/{{ substr(str_replace('-', '_', $row->model->product_number), 0 ,9) }}/200/200/" alt=""></a></div>
                                        <div class="col-sm-9">
                                            <h4 class="nomargin"><a href="{{ route('shop.show', [
                                                        'category1' => str_slug($row->model->category1),
                                                        'category2' => str_slug($row->model->category2),
                                                        'product' => str_slug($row->model->slug)
                                                        ]) }}">{{ $row->model->name }}</a></h4>
                                            <p>Colore: {{ $row->model->color }}<br>
                                                @if($row->model->size != '')
                                                    Taglia: {{ $row->model->size }}<br>
                                                @endif
                                                {{ $row->model->short_description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Prezzo">€{{ number_format((float)$row->price, 2, ',', '.') }}</td>
                                <td data-th="Quantità" style="text-align: right!important;">
                                    <form action="{{ route('cart.destroy', $row->rowId) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                    <form action="{{ route('cart.update', $row->rowId) }}" method="POST">
                                        {{ csrf_field() }}
                                        <button class="btn btn-info btn-sm" style="margin: 0 15px;"><i class="fa fa-refresh"></i></button>
                                        <input name="product_quantity" type="number" class="form-control text-center" value="{{ $row->qty }}" max="{{ $row->model->stock }}" style="width: 65px; float: right; nav-right: 15px;">
                                    </form>
                                </td>
                                <td data-th="Subtotale" class="text-center" style="text-align: right!important;">€{{ number_format((float)$row->subtotal, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="visible-xs">
                                <td colspan="3" class="hidden-xs"></td>
                                <td class="text-right">Spedizione: <strong>€{{ number_format((float)$shipping, 2, ',', '.') }}</strong></td>
                            </tr>
                            <tr class="visible-xs">
                                <td colspan="3" class="hidden-xs"></td>
                                <td class="text-right">Totale: <strong>€{{ number_format((float)Cart::instance('default')->subtotal + $shipping, 2, ',', '.') }}</strong></td>
                            </tr>

                            <tr class="visible-xs">
                                <td colspan="3" class="hidden-xs"></td>
                                <td class="text-right">IVA (22%): <strong>€{{ number_format((float)Cart::instance('default')->tax + $shipping * 0.22, 2, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="hidden-xs"></td>
                                <td class="hidden-xs text-right">Totale con IVA: <strong>€{{ number_format((float)Cart::instance('default')->total + $shipping * 1.22, 2, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('shop') }}" class="btn btn-outline-primary shopping"><i class="fa fa-angle-left"></i> Continua lo Shopping</a></td>
                                <td colspan="3" class="hidden-xs"></td>
                                <td><a href="{{ route('checkout.index') }}" class="btn btn-outline-primary">Checkout <i class="fa fa-angle-right"></i></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <style>

    </style>
@endsection