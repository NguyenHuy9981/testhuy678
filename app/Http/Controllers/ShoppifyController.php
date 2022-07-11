<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Shop;
use GuzzleHttp\Client;
use App\Jobs\CreateProduct;
use Illuminate\Http\Request;

class ShoppifyController extends Controller
{

    public function index()
    {
        return view('input');
    }

    public function store(Request $request)
    {

        $copes = 'read_products';
        $redirect_uri = '' . config('app.url') . '/testhuy678/authenticate';
        $url = 'https://' . $request['shop_name'] . '.myshopify.com/admin/oauth/authorize?client_id=' . config('app.api_key') . '&scope=' . $copes . '&redirect_uri=' . $redirect_uri . '';

        return redirect($url);
    }



    public function authenticate(Request $request)
    {
        // Lấy access_token
        $code = $request->code;
        $shop_name = $request->shop;

        $client = new Client();
        $res_token = $client->request('POST', 'https://' . $shop_name . '/admin/oauth/access_token', [
            'form_params' => [
                'client_id' => config('app.api_key'),
                'client_secret' => config('app.api_secret'),
                'code' => $code
            ]
        ]);
        $data = (array) json_decode($res_token->getBody());


        // Lấy và lưu dữ liệu shop
        $products = $this->getProduct($data['access_token'], $shop_name);
        $this->shop($data, $shop_name, $products);

        //Lưu SESSION xác thực
        $request->session()->put('token', $data['access_token']);

        return redirect(route('product.index'));
    }

    public function shop($data_token, $shop_name, $products)
    {
        $client = new Client();
        $uri = 'https://' . $shop_name . '/admin/api/2022-07/shop.json';
        $resShop = $client->request('GET', $uri, [
            'headers' => [
                'X-Shopify-Access-Token' => $data_token['access_token']
            ],
        ]);
        $shop = json_decode($resShop->getBody())->shop;



        if (!Shop::where('shopify_domain', 'like', $shop_name)->exists()) {

            $shop_save = Shop::create([
                'name' => $shop->name,
                'domain' => $shop->domain,
                'email' => $shop->email,
                'shopify_domain' => $shop->myshopify_domain,
                'access_token' => $data_token['access_token'],
                'plan_display_name' => $shop->plan_display_name,
                'plan_name' => $shop->plan_name,
                'shop_created_at' => substr($shop->created_at, 0, -15)
            ]);

            foreach ($products as $product) {

                $shop_save->products()->create([
                    'title' => $product->title,
                    'description' => $product->body_html,
                    'image' => isset($product->image) && !empty($product->image) ? $product->image->src : null,
                    'id_product_shopify' => $product->id
                ]);
            }
        }
    }


    public function getProduct($token, $name_shop)
    {
        $client2 = new Client();
        $uri = 'https://' . $name_shop . '/admin/api/2022-07/products.json';
        $resProduct = $client2->request('GET', $uri, [
            'headers' => [
                'X-Shopify-Access-Token' => $token
            ],
        ]);
        $res_products = (array) json_decode($resProduct->getBody())->products;

        return $res_products;
    }


    public function createWebhook(Request $request)
    {

        $topics = [
            [
                'topic' => 'products/create',
                'address' => 'https://19df-2001-ee0-5005-94b0-5971-5482-b995-2cc4.ap.ngrok.io/testhuy678/api/createProduct',
            ],
            [
                'topic' => 'products/update',
                'address' => 'https://19df-2001-ee0-5005-94b0-5971-5482-b995-2cc4.ap.ngrok.io/testhuy678/api/updateProduct',
            ],
            [
                'topic' => 'products/delete',
                'address' => 'https://19df-2001-ee0-5005-94b0-5971-5482-b995-2cc4.ap.ngrok.io/testhuy678/api/deleteProduct',
            ],
        ];

        foreach ($topics as $value) {
            $shop_token = $request->session()->get('token');
            $url = 'https://testhuy678.myshopify.com/admin/api/2022-07/webhooks.json';
            $client = new Client();
            $$client->request('POST', $url, [
                'headers' => [
                    'X-Shopify-Access-Token' => $shop_token,
                ],
                'form_params' => [
                    'webhook' =>
                    [

                        'topic' => $value['topic'],
                        'format' => 'json',
                        'address' => $value['address'],

                    ],


                ]
            ]);
        }

        return view('webhook.success');
    }

    public function createProduct(Request $request)
    {
        // $job = new CreateProduct($request->all());
        // dispatch($job);
        Product::create([
            'title' => $request['title'],
            'description' => $request['body_html'],
            'image' => $request['image']['src'],
            'shop_name' => $request['vendor'],
            'id_product_shopify' => $request['id']

        ]);
    }

    public function deleteProduct(Request $request)
    {
        Product::where('id_product_shopify', $request['id'])->delete();
    }

    public function updateProduct(Request $request)
    {
        Product::where('id_product_shopify', $request['id'])->update([
            'title' => $request['title'],
            'description' => $request['body_html'],
            'image' => $request['image']['src'],
            'shop_name' => $request['vendor'],
            'id_product_shopify' => $request['id']
        ]);
    }
}
