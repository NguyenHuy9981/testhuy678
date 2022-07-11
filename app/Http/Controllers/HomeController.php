<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->session()->has('token'))) {

            $shop_token = $request->session()->get('token');

            $shop = Shop::where('access_token', 'like', $shop_token)->first();

            $products = $shop->products;
            return view('product.index', compact('shop', 'products','shop_token'));
        } else {
            abort(403);
        }
    }
}
