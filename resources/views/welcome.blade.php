<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>RePromotion</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="flex-center position-ref">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <h2>Prodotti non presenti in catalogo</h2>
                    <table class="table table-striped table-condensed">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">PRODUCT_NUMBER</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notPresent as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{  $item }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    <h2>Stock</h2>
                    <table class="table table-striped table-condensed">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            @foreach($productStockVars as $productStockVar)
                                <th scope="col">{{ $productStockVar }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stock as $stockProduct)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{  $stockProduct['ID'] }}</td>
                                <td>{{  $stockProduct['QUANTITY'] }}</td>
                                <td>{{  $stockProduct['ARRIVAL']['QUANTITY'] }}</td>
                                <td>{{  $stockProduct['ARRIVAL']['DATE'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    <h2>Catalogo</h2>
                    <table class="table table-striped table-condensed">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                @foreach($productVars as $productVar)
                                    <th scope="col">{{ $productVar }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    @foreach($productVars as $productVar)
                                        <td>{{  $product[$productVar] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
