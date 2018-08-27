<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Product;
use App\Price;
use App\Printprice;
use App\Printinfo;
use App\Arrival;

class MidoceanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/midocean/prodinfo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prodinfo()
    {
        // Load catalog files from FTP external server
        $xmlFile = Storage::disk('ftp')->get('prodinfo_IT.xml');
        $xmlFileTextile = Storage::disk('ftp')->get('prodinfo_TEXTILE_IT.xml');
        $xmlFileUsb = Storage::disk('ftp')->get('USBprodinfo.xml');

        // Store catalog files in local storage
        Storage::disk('local')->put('public/xml/midocean/prodinfo_IT.xml', $xmlFile);
        Storage::disk('local')->put('public/xml/midocean/prodinfo_TEXTILE_IT.xml', $xmlFileTextile);
        Storage::disk('local')->put('public/xml/midocean/USBprodinfo.xml', $xmlFileUsb);



        //Processing PRODINFO

        $xmlProdInfo = XmlParser::load('storage/xml/midocean/prodinfo_IT.xml');

        $products = $xmlProdInfo->getContent();

        Product::where('catalog', 'Midocean')->delete();

        // import user uploaded excel file with products list
        $productList = collect((new FastExcel)->import('storage/xlsx/product_list.xlsx')->sortBy('PRODUCT_BASE_NUMBER'));

        foreach ($products->PRODUCTS->PRODUCT as $item) {

            foreach ($productList as $itemList) {
                if ($itemList['PRODUCT_NUMBER'] == $item->PRODUCT_NUMBER)
                {
                    $product = Product::create([
                        'product_number' => (string)$item->PRODUCT_NUMBER,
                        'product_base' => (string)$item->PRODUCT_BASE_NUMBER,
                        'name' => (string)$item->PRODUCT_NAME,
                        'slug' => str_slug((string)$item->PRODUCT_NAME, '-'),
                        'color' => (string)$item->COLOR_DESCRIPTION,
                        'position' => '',
                        'print_model' => '',
                        'size' => '',
                        'catalog' => 'Midocean',
                        'print_price' => 0,
                        'stock' => 0,
                        'min' => $itemList['MIN'],
                        'category1' => (string)$item->CATEGORY_LEVEL_2,
                        'category2' => (string)$item->CATEGORY_LEVEL_3,
                        'category3' => (string)$item->CATEGORY_LEVEL_4,
                        'short_description' => (string)$item->SHORT_DESCRIPTION,
                        'long_description' => (string)$item->LONG_DESCRIPTION,
                        'material_type' => (string)$item->MATERIAL_TYPE,
                        'dimensions' => (string)$item->DIMENSIONS,
                        'gender' => '',
                        'start_price' => 0,
                    ]);
                    break;
                }
            }
        }

        //Processing PRODINFOTEXTILE

        $xmlProdInfoTextile = XmlParser::load('storage/xml/midocean/prodinfo_TEXTILE_IT.xml');

        $products = $xmlProdInfoTextile->getContent();

        foreach ($products->PRODUCTS->PRODUCT as $item) {

            foreach ($productList as $itemList) {

                if ($itemList['PRODUCT_NUMBER'] == $item->PRODUCT_NUMBER) {

                    $product = Product::create([
                        'product_number' => (string)$item->PRODUCT_NUMBER,
                        'product_base' => (string)$item->PRODUCT_BASE_NUMBER,
                        'name' => (string)$item->PRODUCT_NAME,
                        'slug' => str_slug((string)$item->PRODUCT_NAME, '-'),
                        'color' => (string)$item->COLOR_DESCRIPTION,
                        'position' => '',
                        'print_model' => '',
                        'size' => (string)$item->SIZE,
                        'catalog' => 'Midocean',
                        'stock' => 0,
                        'min' => $itemList['MIN'],
                        'category1' => (string)$item->CATEGORY_LEVEL_2,
                        'category2' => (string)$item->CATEGORY_LEVEL_3,
                        'category3' => (string)$item->CATEGORY_LEVEL_4,
                        'short_description' => (string)$item->SHORT_DESCRIPTION,
                        'long_description' => (string)$item->LONG_DESCRIPTION,
                        'material_type' => (string)$item->MATERIAL_TYPE,
                        'dimensions' => (string)$item->DIMENSIONS,
                        'gender' => (string)$item->GENDER,
                        'start_price' => 0,
                    ]);
                    break;
                }
            }
        }

        return redirect('/midocean/printinfo');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printinfo()
    {

        Printinfo::truncate();

        // import user uploaded excel file with products print ifos
        $productListPrint = collect((new FastExcel)->import('storage/xlsx/test_data.xlsx')->sortBy('PRODUCT_BASE_NUMBER'));

        foreach ($productListPrint as $itemListPrint) {

            if ($itemListPrint['PRODUCT_BASE_NUMBER'] == '')
                continue;

            $printinfo = Printinfo::create([
                'product_base_number' => (string)$itemListPrint['PRODUCT_BASE_NUMBER'],
                'printing_position' => (string)$itemListPrint['PRINTING_POSITION'],
                'printing_technique' => (string)$itemListPrint['PRINTING_TECHNIQUE'],
                'printing_technique_description' => (string)$itemListPrint['PRINTING_TECHNIQUE_DESCRIPTION'],
                'print_model' => (string)$itemListPrint['PRINT_MODEL'],
                'pricing_type' => 'NA',
                'area' => (integer)$itemListPrint['AREA'],
                'number_of_colours' => (integer)$itemListPrint['NUMBER_OF_COLOURS'],
                'manipulation' => '',
                'color_code' => (string)$itemListPrint['COLOR'],
                'min_qty' => 1,
                'setup' => 0,
                'price' => 0,
                'handling' => 0,
                'apply' => 0,
            ]);

            $basecol = (string)$itemListPrint['PRODUCT_BASE_NUMBER'].'-'.(string)$itemListPrint['COLOR'];

            if (!isset(Product::where('product_number', 'like', $basecol.'%')->first()->position))
                dd($basecol);

            if (Product::where('product_number', 'like', $basecol.'%')->first()->position == '')
            {
                $product = Product::where('product_number', 'like', $basecol.'%')
                    ->update([
                        'position' => (string)$itemListPrint['PRINTING_POSITION'],
                        'print_model' => (string)$itemListPrint['PRINT_MODEL'],
                    ]);
            }
            else
            {
                foreach (Product::where('product_number', 'like', $basecol.'%')
                             ->select('product_number', 'product_base', 'size', 'catalog', 'stock', 'min', 'dimensions', 'gender', 'start_price', 'name', 'slug', 'category1', 'category2', 'category3', 'color', 'material_type', 'short_description', 'long_description')
                             ->groupBy('product_number', 'product_base', 'size', 'catalog', 'stock', 'min', 'dimensions', 'gender', 'start_price', 'name', 'slug', 'category1', 'category2', 'category3', 'color', 'material_type', 'short_description', 'long_description')
                             ->get() as $prod)
                {
                    $product = Product::create([
                        'product_number' => $prod->product_number,
                        'product_base' => $prod->product_base,
                        'name' => $prod->name,
                        'slug' => $prod->slug,
                        'color' => $prod->color,
                        'position' => (string)$itemListPrint['PRINTING_POSITION'],
                        'print_model' => (string)$itemListPrint['PRINT_MODEL'],
                        'size' => $prod->size,
                        'catalog' => $prod->catalog,
                        'stock' => $prod->stock,
                        'min' => $prod->min,
                        'category1' => $prod->category1,
                        'category2' => $prod->category2,
                        'category3' => $prod->category3,
                        'short_description' => $prod->short_description,
                        'long_description' => $prod->long_description,
                        'material_type' => $prod->material_type,
                        'dimensions' => $prod->dimensions,
                        'gender' => $prod->gender,
                        'start_price' => $prod->start_price,
                    ]);
                }
            }

        }

        //Processing PRINTINFO

        $xmlPrint = XmlParser::load('storage/xml/midocean/printinfo.xml');

        $products = $xmlPrint->getContent();

        foreach ($products->PRODUCTS->PRODUCT as $item) {

            $prodBase = Product::where('product_base', (string) $item->PRODUCT_BASE_NUMBER)->first();

            if (!empty($prodBase))
            {
                $printinfoupdate = Printinfo::where('product_base_number', '=', (string) $item->PRODUCT_BASE_NUMBER)
                    ->update([
                        'manipulation' => $item->MANIPULATION
                    ]);
            }
        }

        //Processing PRINTINFO

        $xmlPrintTextile = XmlParser::load('storage/xml/midocean/printinfo_textile.xml');

        $products = $xmlPrintTextile->getContent();

        foreach ($products->PRODUCTS->PRODUCT as $item) {

            $prodBase = Product::where('product_base', (string) $item->PRODUCT_BASE_NUMBER)->first();

            if (!empty($prodBase))
            {
                $printinfoupdate = Printinfo::where('product_base_number', '=', (string) $item->PRODUCT_BASE_NUMBER)
                    ->update([
                        'manipulation' => $item->MANIPULATION
                    ]);
            }
        }

        $printinfoupdate = Printinfo::where('area', '=', 0)->delete();

        return redirect('/midocean/priceimport');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function priceImport()
    {
        // Dati di accesso per il webservice Midocean per il listino prezzi
        $url = 'http://b2b.midoceanbrands.com/invoke/b2b.main/get_pricelist_xml';
        $customerNumber = "80868040";
        $login = "83538";
        $password = "80868040";
        $timestamp = date("YmdHis", time());

        // Richiesta curl al webservice midocean
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "
            <xml>
                <?xml version=\"1.0\" encoding=\"UTF-8\"?>
                <PRICELIST_REQUEST>
                    <CUSTOMER_NUMBER>" . $customerNumber . "</CUSTOMER_NUMBER>
                    <LOGIN>" . $login . "</LOGIN>
                    <PASSWORD>" . $password . "</PASSWORD>
                    <TIMESTAMP>" . $timestamp . "</TIMESTAMP>
                </PRICELIST_REQUEST>
            </xml>
        ");
        $result = curl_exec($ch);
        curl_close($ch);

        // creo file xml dei prezzi
        Storage::disk('local')->put('public/xml/midocean/prod_price.xml', $result);

        return redirect('/midocean/price');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function price()
    {

        // eseguo il parse del file xml
        $xmlPrice = XmlParser::load('storage/xml/midocean/prod_price.xml');
        // Trasferisco il contenuto del file xml in $products
        $products = $xmlPrice->getContent();

        foreach ($products->PRODUCTS->PRODUCT as $item) {

            $prodId = Product::where('product_number', $item->PRODUCT_NUMBER)->first();

            if (!empty($prodId))
            {
                foreach (Product::where('product_number', $item->PRODUCT_NUMBER)->get() as $prodotto)
                {
                    if (empty($item->SCALES->SCALE))
                    {
                        $price = Price::create([
                            'product_id' =>  $prodotto->id,
                            'min_qty' => 1,
                            'price' => floatval(str_replace(',', '.', str_replace('.', '', (string) $item->PRICE))),
                        ]);
                    }
                    else
                    {
                        foreach ($item->SCALES->SCALE as $scale) {
                            $price = Price::create([
                                'product_id' =>  $prodotto->id,
                                'min_qty' => floatval(str_replace(',', '.', str_replace('.', '', (string) $scale->MINIMUM_SCALE_AMOUNT))),
                                'price' => floatval(str_replace(',', '.', str_replace('.', '', (string) $scale->SCALE_ITEM_PRICE))),
                            ]);
                        }
                    }
                }
            }

        }

        return redirect('/midocean/printpriceimport');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printPriceImport()
    {
        // Dati di accesso per il webservice Midocean per il listino prezzi di stampa
        $url = 'http://b2b.midoceanbrands.com/invoke/b2b.main/get_print_pricelist';
        $customerNumber = "80868040";
        $login = "83538";
        $password = "80868040";

        // Richiesta curl al webservice midocean
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, "
            <xml>
                <?xml version=\"1.0\" encoding=\"UTF-8\"?>
                <PRINT_PRICELIST_REQUEST>
                    <CUSTOMER_NUMBER>".$customerNumber."</CUSTOMER_NUMBER>
                    <LOGIN>".$login."</LOGIN>
                    <PASSWORD>".$password."</PASSWORD>
                </PRINT_PRICELIST_REQUEST>
            </xml>
        " );
        $result = curl_exec($ch);
        curl_close($ch);

        // creo file xml dei prezzi di stampa
        Storage::disk('local')->put('public/xml/midocean/prod_print_price.xml', $result);

        return redirect('/midocean/printprice');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printprice()
    {
        // eseguo il parse del file xml
        $xmlPrintPrice = XmlParser::load('storage/xml/midocean/prod_print_price.xml');
        // Trasferisco il contenuto del file xml in $products
        $products = $xmlPrintPrice->getContent();

        foreach ($products->PRINTING_TECHNIQUES->PRINTING_TECHNIQUE as $item) {
            $printinfoupdate = Printinfo::where('printing_technique_description', '=', (string)$item->DESCRIPTION)
                ->update([
                    'pricing_type' => (string)$item->PRICING_TYPE,
                    'printing_technique_description' => (string)$item->DESCRIPTION
                ]);
            $printinfoupdate = Printinfo::where('printing_technique', '=', (string)$item->ID)
                ->update([
                    'pricing_type' => (string)$item->PRICING_TYPE,
                    'printing_technique_description' => (string)$item->DESCRIPTION
                ]);

            foreach (Printinfo::where('printing_technique', '=', (string)$item->ID)->get() as $baseProd) {

                $setupBase = floatval(str_replace(',', '.', str_replace('.', '', (string)$item->SETUP)));
                $setupRepeat = floatval(str_replace(',', '.', str_replace('.', '', (string)$item->SETUP_REPEAT)));
                $applyCost = floatval(str_replace(',', '.', str_replace('.', '', (string)$item->APPLY_COST)));
                $handlingCost = 0;
                $area = $baseProd->area / 100;

                foreach ($products->MANIPULATIONS->MANIPULATION as $manipulation) {

                    $manipulationCode = (string)$manipulation->CODE;

                    if ($manipulationCode == $baseProd->manipulation) {
                        $handlingCost = floatval(str_replace(',', '.', str_replace('.', '', (string)$manipulation->PRICE)));
                    }
                }

                switch ($baseProd->pricing_type) {

                    case 'NumberOfColours':
                        $nextColourIndicator = (string)$item->NEXT_COLOUR_COST_INDICATOR;
                        $setupCost = $baseProd->number_of_colours * $setupBase;

                        foreach ($item->VAR_COSTS->VAR_COST->SCALES->SCALE as $scale) {
                            $printBase = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_1ST)));
                            $printNext = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_NEXT)));
                            $min_qty = intval(str_replace('.', '', (string)$scale->QTY_MIN));

                            if ($nextColourIndicator == 'X') {
                                $printCost = $printBase + $printNext * ($baseProd->number_of_colours - 1);
                            } else {
                                $printCost = $printBase * $baseProd->number_of_colours;
                            }

                            $this->updatePrintInfo($baseProd, $min_qty, $setupCost, $handlingCost, $applyCost, $printCost);
                        }
                        break;

                    case 'ColourAreaRange':
                        $nextColourIndicator = (string)$item->NEXT_COLOUR_COST_INDICATOR;
                        $setupCost = $baseProd->number_of_colours * $setupBase;

                        if ($nextColourIndicator == 'X') {
                            foreach ($item->VAR_COSTS->VAR_COST as $varCost) {

                                if ($area >= (integer)$varCost->AREA_FROM and $area <= (integer)$varCost->AREA_TO) {
                                    foreach ($varCost->SCALES->SCALE as $scale) {
                                        $printBase = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_1ST)));
                                        $printNext = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_NEXT)));
                                        $min_qty = intval(str_replace('.', '', (string)$scale->QTY_MIN));

                                        $printCost = $printBase + $printNext * ($baseProd->number_of_colours - 1);

                                        $this->updatePrintInfo($baseProd, $min_qty, $setupCost, $handlingCost, $applyCost, $printCost);
                                    }
                                }
                            }
                        } else {
                            foreach ($item->VAR_COSTS->VAR_COST as $varCost) {

                                if ($area >= (integer)$varCost->AREA_FROM and $area <= (integer)$varCost->AREA_TO) {
                                    foreach ($varCost->SCALES->SCALE as $scale) {
                                        $printBase = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_1ST)));
                                        $printNext = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_NEXT)));
                                        $min_qty = intval(str_replace('.', '', (string)$scale->QTY_MIN));

                                        $printCost = $printBase * $baseProd->number_of_colours;

                                        $this->updatePrintInfo($baseProd, $min_qty, $setupCost, $handlingCost, $applyCost, $printCost);
                                    }
                                }
                            }
                        }
                        break;

                    case 'Area':
                        $setupCost = $setupBase;
                        foreach ($item->VAR_COSTS->VAR_COST as $varCost) {
                            foreach ($varCost->SCALES->SCALE as $scale) {
                                $printBase = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_1ST)));
                                $min_qty = intval(str_replace('.', '', (string)$scale->QTY_MIN));

                                $printCost = $printBase * $area;

                                $this->updatePrintInfo($baseProd, $min_qty, $setupCost, $handlingCost, $applyCost, $printCost);
                            }
                        }
                        break;

                    case 'NumberOfPositions':
                        $setupCost = $setupBase;
                        foreach ($item->VAR_COSTS->VAR_COST as $varCost) {
                            foreach ($varCost->SCALES->SCALE as $scale) {
                                $printBase = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_1ST)));
                                $min_qty = intval(str_replace('.', '', (string)$scale->QTY_MIN));

                                $printCost = $printBase;

                                $this->updatePrintInfo($baseProd, $min_qty, $setupCost, $handlingCost, $applyCost, $printCost);
                            }
                        }

                        break;

                    case 'AreaRange':
                        $setupCost = $setupBase;

                        foreach ($item->VAR_COSTS->VAR_COST as $varCost) {

                            if ($area >= (integer)$varCost->AREA_FROM and $area <= (integer)$varCost->AREA_TO) {
                                foreach ($varCost->SCALES->SCALE as $scale) {
                                    $printBase = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_1ST)));
                                    $printNext = floatval(str_replace(',', '.', str_replace('.', '', (string)$scale->PRICE_NEXT)));
                                    $min_qty = intval(str_replace('.', '', (string)$scale->QTY_MIN));

                                    $printCost = $printBase;

                                    $this->updatePrintInfo($baseProd, $min_qty, $setupCost, $handlingCost, $applyCost, $printCost);
                                }
                            }
                        }
                        break;
                }
            }
        }

        return redirect('/midocean/printprice2');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printprice2()
    {
        //mapping PRINTINFO

        $xmlPrint = XmlParser::load('storage/xml/midocean/printinfo.xml');

        $printingTechniques = $xmlPrint->parse([
            'printing_techniques' => ['uses' => 'PRINTING_TECHNIQUE_DESCRIPTIONS.PRINTING_TECHNIQUE_DESCRIPTION[::id>printing_technique,NAME(::language=@)]', 'default' => null],
        ]);

        foreach ($printingTechniques['printing_techniques'] as $item) {
            if(isset($item['IT']))
                $printing_technique_description = $item['IT'];
            else
                $printing_technique_description = $item['EN'];
            Printinfo::where('printing_technique',  '=', $item['printing_technique'])
                ->update([
                    'printing_technique_description' => $printing_technique_description
                ]);
        }

        return redirect('/midocean/printprice3');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printprice3()
    {
        //mapping PRINTINFO TEXTILE

        $xmlPrintTextile = XmlParser::load('storage/xml/midocean/printinfo_textile.xml');

        $printingTechniques = $xmlPrintTextile->parse([
            'printing_techniques' => ['uses' => 'PRINTING_TECHNIQUE_DESCRIPTIONS.PRINTING_TECHNIQUE_DESCRIPTION[::id>printing_technique,NAME(::language=@)]', 'default' => null],
        ]);

        foreach ($printingTechniques['printing_techniques'] as $item) {
            if(isset($item['IT']))
                $printing_technique_description = $item['IT'];
            else
                $printing_technique_description = $item['EN'];
            Printinfo::where('printing_technique',  '=', $item['printing_technique'])
                ->update([
                    'printing_technique_description' => $printing_technique_description
                ]);
        }

        return redirect('/midocean/printprice4');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printprice4()
    {

        $base_lists = Printinfo::groupBy('product_base_number', 'color_code', 'printing_position', 'print_model')->select('product_base_number', 'color_code', 'printing_position', 'print_model')->get();

        Printprice::truncate();

        foreach ($base_lists as $base_list)
        {
            $qty_list = Printinfo::where('product_base_number', '=', $base_list->product_base_number)
                ->where('color_code', '=', $base_list->color_code)
                ->where('printing_position', '=', $base_list->printing_position)
                ->where('print_model', '=', $base_list->print_model)
                ->groupBy('min_qty')
                ->select('min_qty')
                ->get();
            foreach ($qty_list as $min_qty)
            {
                $handling = 0;
                $apply = 0;
                $price = 0;
                $setup = 0;

                foreach (Printinfo::where('product_base_number', '=', $base_list->product_base_number)->where('color_code', '=', $base_list->color_code)->where('printing_position', '=', $base_list->printing_position)->where('print_model', '=', $base_list->print_model)->where('min_qty', '=', $min_qty->min_qty)->get() as $item)
                {
                    $handling = $item->handling;

                    switch ($item->pricing_type) {

                        case 'NumberOfColours':

                            $apply += $item->apply;
                            $setup += $item->setup;
                            $price += $item->price;

                            break;

                        case 'ColourAreaRange':

                            $apply += $item->apply;
                            $setup += $item->setup;
                            $price += $item->price;

                            break;

                        case 'Area':

                            $apply += $item->apply;
                            $setup += $item->setup;
                            $price += $item->price;

                            break;

                        case 'NumberOfPositions':

                            $apply += $item->apply;
                            $setup += $item->setup;
                            $price += $item->price;

                            break;

                        case 'AreaRange':

                            $apply += $item->apply;
                            $setup += $item->setup;
                            $price += $item->price;

                            break;
                    }
                }

                $price = $price + $apply + $handling;

                    $printprice = Printprice::create([
                        'product_base' => $base_list->product_base_number,
                        'color_code' => $base_list->color_code,
                        'position' => $base_list->printing_position,
                        'print_model' => $base_list->print_model,
                        'min_qty' => $min_qty->min_qty,
                        'price' => $price,
                        'setup' => $setup,
                    ]);
            }
        }

        return redirect('/midocean/startprice');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function startprice()
    {
        foreach (Product::where('catalog', 'Midocean')->get() as $product)
        {
            Product::where('id', $product->id)->update([
                'start_price' => ( $product->getFinalPrice($product->min) / $product->min ),
                'slug' => str_slug($product->name . ' ' . $product->color . ' ' . $product->position . ' ' . $product->print_model, '-')
            ]);
        }

        return redirect('/midocean/stock');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stock()
    {
        // Load catalog files from FTP external server
        $xmlFileStock = Storage::disk('ftp')->get('stock.xml');
        $xmlFileStockTextile = Storage::disk('ftp')->get('stock_textile.xml');

        // Store catalog files in local storage
        Storage::disk('local')->put('public/xml/midocean/stock.xml', $xmlFileStock);
        Storage::disk('local')->put('public/xml/midocean/stock_textile.xml', $xmlFileStockTextile);
        //Processing STOCK

        $xmlStock = XmlParser::load('storage/xml/midocean/stock.xml');

        $products = $xmlStock->getContent();

        Arrival::truncate();

        foreach ($products->PRODUCTS->PRODUCT as $item) {

            $prodId = Product::where('product_number', $item->ID)->first();

            if (!empty($prodId))
            {
                $quantity = (integer) $item->QUANTITY;
                Product::where('product_number', $item->ID)->update(['stock' => $quantity]);

                if (!empty($item->ARRIVAL))
                {
                    foreach ($item->ARRIVAL as $arrival)
                    {
                        foreach (Product::where('product_number', $item->ID)->get() as $prodv)
                        {
                            Arrival::create([
                                'product_id' =>  $prodv->id,
                                'qty' => $arrival->QUANTITY,
                                'date' => \DateTime::createFromFormat("Ymd", $arrival->DATE),
                            ]);
                        }
                    }
                }
            }

        }

        //Processing STOCKTEXTILE

        $xmlStockTextile = XmlParser::load('storage/xml/midocean/stock_textile.xml');

        $products = $xmlStockTextile->getContent();

        foreach ($products->PRODUCTS->PRODUCT as $item) {

            $prodId = Product::where('product_number', $item->ID)->first();

            if (!empty($prodId))
            {
                $quantity = (integer) $item->QUANTITY;
                Product::where('product_number', $item->ID)->update(['stock' => $quantity]);

                if (!empty($item->ARRIVAL))
                {
                    foreach ($item->ARRIVAL as $arrival)
                    {
                        foreach (Product::where('product_number', $item->ID)->get() as $prodv)
                        {
                            Arrival::create([
                                'product_id' =>  $prodv->id,
                                'qty' => $arrival->QUANTITY,
                                'date' => \DateTime::createFromFormat("Ymd", $arrival->DATE),
                            ]);
                        }
                    }
                }
            }
        }

        dd('fine');
    }

    /**
     * Show the form for catalog sync.
     *
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {
        return view('sync');
    }

    /**
     * Import the excel file from the catalog sync form.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeList(request $request) {
        $file = $request->file('excel');

        // Local destination path
        $destinationPath = 'storage/xlsx';

        // Name of imported file
        $fileName = 'product_list.xlsx';

        // Move file to local path
        $file->move($destinationPath,$fileName);

        return redirect('/midocean');
    }

    private function updatePrintInfo($base, $min_qty, $setup, $handling, $apply,  $price)
    {
        if ($min_qty == 1) {
            $printinfoupdate = Printinfo::where('id', '=', $base->id)
                ->update([
                    'setup' => $setup,
                    'price' => $price,
                    'handling' => $handling,
                    'apply' => $apply,
                ]);
        }
        else {
            $printinfo = Printinfo::create([
                'product_base_number' => $base->product_base_number,
                'printing_position' => $base->printing_position,
                'printing_technique' => $base->printing_technique,
                'printing_technique_description' => $base->printing_technique_description,
                'pricing_type' => $base->pricing_type,
                'area' => $base->area,
                'number_of_colours' => $base->number_of_colours,
                'manipulation' => $base->manipulation,
                'color_code' => $base->color_code,
                'print_model' => $base->print_model,
                'min_qty' => $min_qty,
                'setup' => $setup,
                'price' => $price,
                'handling' => $handling,
                'apply' => $apply,
            ]);
        }
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
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
