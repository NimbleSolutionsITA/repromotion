<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;
use Orchestra\Parser\Xml\Facade as XmlParser;
use App\Product;
use App\Price;
use App\Printprice;
use App\Printinfo;
use App\Arrival;

class UpdateMidocean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:midocean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Midocean catalog stock and prices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
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

        $path = storage_path('app/public/xml/midocean/prod_price.xml');


        // eseguo il parse del file xml
        $xmlPrice = XmlParser::load($path);
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




        $path = storage_path('app/public/xml/midocean/prod_print_price.xml');

        // eseguo il parse del file xml
        $xmlPrintPrice = XmlParser::load($path);
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



        //mapping PRINTINFO
        $path = storage_path('app/public/xml/midocean/printinfo.xml');

        $xmlPrint = XmlParser::load($path);

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




        //mapping PRINTINFO TEXTILE
        $path = storage_path('app/public/xml/midocean/printinfo_textile.xml');

        $xmlPrintTextile = XmlParser::load($path);

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



        foreach (Product::where('catalog', 'Midocean')->get() as $product)
        {
            Product::where('id', $product->id)->update([
                'start_price' => ( $product->getFinalPrice($product->min) / $product->min ),
                'slug' => str_slug($product->name . ' ' . $product->color . ' ' . $product->position . ' ' . $product->print_model, '-')
            ]);
        }




        // Load catalog files from FTP external server
        $xmlFileStock = Storage::disk('ftp')->get('stock.xml');
        $xmlFileStockTextile = Storage::disk('ftp')->get('stock_textile.xml');

        // Store catalog files in local storage
        Storage::disk('local')->put('public/xml/midocean/stock.xml', $xmlFileStock);
        Storage::disk('local')->put('public/xml/midocean/stock_textile.xml', $xmlFileStockTextile);
        //Processing STOCK
        $path = storage_path('app/public/xml/midocean/stock.xml');

        $xmlStock = XmlParser::load($path);

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
        $path = storage_path('app/public/xml/midocean/stock_textile.xml');

        $xmlStockTextile = XmlParser::load($path);

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
}
