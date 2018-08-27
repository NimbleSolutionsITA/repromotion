<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abbigliamento = Product::where('category1', 'ABBIGLIAMENTO')->inRandomOrder()->take(4)->get();
        $viaggi = Product::where('category1', 'BORSE & VIAGGI')->inRandomOrder()->take(4)->get();
        $casa= Product::where('category1', 'CASA & VIVERE')->inRandomOrder()->take(4)->get();
        $ufficio= Product::where('category1', 'UFFICIO')->inRandomOrder()->take(4)->get();

        return view('home')
            ->with('abbigliamento', $abbigliamento)
            ->with('viaggi', $viaggi)
            ->with('casa', $casa)
            ->with('ufficio', $ufficio);
    }
}
