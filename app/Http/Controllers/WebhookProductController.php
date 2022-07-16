<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Product;
use App\Jobs\CreateProduct;
use Illuminate\Http\Request;

class WebhookProductController extends Controller
{

    public function createWebhook(Request $request)
    {
        if (isset($request['access_token']) && !empty($request['access_token'])) {
            $topics = [
                [
                    'topic' => 'products/create', // Khúc dưới address em ghi route('tên route') nhưng bị lỗi nên để tạm link a
                    'address' => '' . config('app.url') . '/testhuy678/api/createProduct',
                ],
                [
                    'topic' => 'products/update',
                    'address' => '' . config('app.url') . '/testhuy678/api/updateProduct',
                ],
                [
                    'topic' => 'products/delete',
                    'address' => '' . config('app.url') . '/testhuy678/api/deleteProduct',
                ],
            ];

            foreach ($topics as $value) {
                $url = 'https://' . $request['shop_name'] . '/admin/api/2022-07/webhooks.json';
                $client = new Client();
                $client->request('POST', $url, [
                    'headers' => [
                        'X-Shopify-Access-Token' => $request['access_token'],
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
        } else
            return view('webhook.fail');
    }

    public function createProduct(Request $request)
    {
        // $job = new CreateProduct($request->all());
        // dispatch($job);

        Product::create([
            'title' => $request['title'],
            'description' => $request['body_html'],
            'image' => isset($request['image']) && !empty($request['image']) ? $request['image']['src'] : null,
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
            'image' => isset($request['image']) && !empty($request['image']) ? $request['image']['src'] : null,
            'shop_name' => $request['vendor'],
            'id_product_shopify' => $request['id']
        ]);
    }
}
