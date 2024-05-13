<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function home(Request $request)
    {
        $products = Product::with('breeds')->paginate(20);

        return view('pages.home',[
            'products' => $products,
        ]);
    }
}
