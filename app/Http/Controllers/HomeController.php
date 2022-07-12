<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use GuzzleHttp\Client;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->session()->has('token'))) {

            $shop_token = $request->session()->get('token');

            $shop = Shop::where('access_token', 'like', $shop_token)->first();

            $products = $shop->products;
            return view('product.index', compact('shop', 'products', 'shop_token'));
        } else {
            abort(403);
        }
    }


    public function createProduct()
    {
        return view('product.create');
    }

    public function createProduct_UpShopify(Request $request)
    {
        $shop_token = $request->session()->get('token');
        $shop_name = $request->session()->get('nameShop');

        $client = new Client();
        $uri = 'https://' . $shop_name . '/admin/api/2022-07/products.json';
        $client->request('POST', $uri, [
            'headers' => [
                'X-Shopify-Access-Token' => $shop_token
            ],
            'form_params' => [
                'product' =>
                [
                    'title' => $request['title'],
                    'body_html' => $request['description'],
                ]
            ],
        ]);

        return redirect(route('product.index'));
    }


    public function editProduct(Request $request, $id)
    {
        $product = Product::where('id_product_shopify', $id)->first();

        return view('product.edit', compact('product'));
    }

    public function updateProduct_UpShopify(Request $request, $id)
    {
        $shop_token = $request->session()->get('token');
        $shop_name = $request->session()->get('nameShop');

        $client = new Client();
        $uri = 'https://' . $shop_name . '/admin/api/2022-07/products/' . $id . '.json';
        $client->request('PUT', $uri, [
            'headers' => [
                'X-Shopify-Access-Token' => $shop_token
            ],
            'form_params' => [
                'product' => [
                    'title' => $request['title'],
                    'body_html' => $request['description'],
                ]
            ],
        ]);

        return redirect(route('product.index'));
    }


    public function deleteProduct_UpShopify(Request $request, $id)
    {
        $shop_token = $request->session()->get('token');
        $shop_name = $request->session()->get('nameShop');

        $client = new Client();
        $uri = 'https://' . $shop_name . '/admin/api/2022-07/products/' . $id . '.json';
        $client->request('DELETE', $uri, [
            'headers' => [
                'X-Shopify-Access-Token' => $shop_token
            ],
        ]);

        echo 'Xóa thành công';
    }
}
