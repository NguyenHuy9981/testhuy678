<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateProduct;
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

    public function createProduct_UpShopify(ValidateProduct $request)
    {
        $shop_token = $request->session()->get('token');
        $shop_name = $request->session()->get('nameShop');

        /// Tạo sản phẩm 
        $client = new Client();
        $uri = 'https://' . $shop_name . '/admin/api/2022-07/products.json';
        $product = $client->request('POST', $uri, [
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

        $createProduct = (array) json_decode($product->getBody())->product;

        // Tạo Image
        $this->createImage($request, $createProduct['id']);

        sleep(config('app.create_product_timeout'));

        return redirect(route('product.index'));
    }

    public function createImage($request, $product_id)
    {
        $shop_token = $request->session()->get('token');
        $shop_name = $request->session()->get('nameShop');

        if (file_exists($request['image'])) {
            $client = new Client();
            $urlProductImage = 'https://' . $shop_name . '/admin/api/2022-07/products/' . $product_id . '/images.json';
            $client->request('POST', $urlProductImage, [
                'headers' => [
                    'X-Shopify-Access-Token' => $shop_token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'image' => [
                        'attachment' => base64_encode(file_get_contents($request['image'])),
                        'filename' => $request['image']->getClientOriginalName(),
                    ]
                ]
            ]);
        }
    }

    public function updateImage($request, $product_id, $image_id)
    {
        $shop_token = $request->session()->get('token');
        $shop_name = $request->session()->get('nameShop');

        if (file_exists($request['image'])) {

            $client = new Client();
            $urlProductImage = 'https://' . $shop_name . '/admin/api/2022-07/products/' . $product_id . '/images/' . $image_id . '.json';
            $image = $client->request('PUT', $urlProductImage, [
                'headers' => [
                    'X-Shopify-Access-Token' => $shop_token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'image' => [
                        'attachment' => base64_encode(file_get_contents($request['image'])),
                        'filename' => $request['image']->getClientOriginalName(),
                    ]
                ]
            ]);

            $updateImage = (array) json_decode($image->getBody());

            return $updateImage;
        }
    }



    public function editProduct(Request $request, $id)
    {
        $product = Product::where('id_product_shopify', $id)->first();

        return view('product.edit', compact('product'));
    }

    public function updateProduct_UpShopify(ValidateProduct $request, $id)
    {

        $shop_token = $request->session()->get('token');
        $shop_name = $request->session()->get('nameShop');

        $client = new Client();
        $uri = 'https://' . $shop_name . '/admin/api/2022-07/products/' . $id . '.json';
        $product = $client->request('PUT', $uri, [
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

        $updateProduct = (array) json_decode($product->getBody())->product;

        $id_image = $updateProduct['image']->id;

        // Update Hình ảnh
        $image = $this->updateImage($request, $updateProduct['id'], $id_image);

        $imageUpdate = $image['image']->src;

        Product::where('id_product_shopify', $updateProduct['id'])
            ->update([
                'image' => $imageUpdate,
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
