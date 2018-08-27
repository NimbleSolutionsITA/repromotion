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

        <!-- Styles -->
        <style>
            html, body, .container-table {
                height: 100%;
            }
            .container-table {
                display: table;
            }
            .vertical-center-row {
                display: table-cell;
                vertical-align: middle;
            }
        </style>
    </head>
    <body>
        <div class="container container-table">
            <div class="row vertical-center-row">
                <div class="text-center col-md-4 col-md-offset-4">
                    <form action="/midocean-storeList" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sincronizzazione catalogo Midocean</label>
                            <input  type="file" name="excel" class="form-control" id="excel" aria-describedby="excelHelp" placeholder="Seleziona il file excel">
                            <small id="excelHelp" class="form-text text-muted">Seleziona il file excel con la lista di prodotti del catalogo Midocean</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Carica il file</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
