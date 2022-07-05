<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ShoppifyController extends Controller
{
    
    public function index() 
    {
        return view('input');
    }

    public function store(Request $request) {
    
        $api_key = '8aeef13b97dbd8b1938c60e67394219c';
        $copes = 'read_customers';
        $redirect_uri = 'https://localhost/testhuy678/authenticate';
        
        $url = 'https://'.$request['shop_name'].'.myshopify.com/admin/oauth/authorize?client_id='.$api_key.'&scope='.$copes.'&redirect_uri='.$redirect_uri.'';

        return redirect()->to($url);
    }

    // public function authenticate(Request $request) {
    //     // dd($request['code']);
    //     $api_key = '8aeef13b97dbd8b1938c60e67394219c';
    //     $api_secret = 'ab54fbc6da54704d7013194a38e706bd';
    //     $code = $request['code'];
    //     return view('authenticate', compact('api_key', 'api_secret', 'code'));
    // }

    public function authenticate(Request $request) {
        $api_key = '8aeef13b97dbd8b1938c60e67394219c';
        $api_secret = 'ab54fbc6da54704d7013194a38e706bd';
        $code = $request->code;
        $shop_name = $request->shop;

        $client = new Client();
        $res_token = $client->request('POST', 'https://'.$shop_name.'/admin/oauth/access_token', [
            'form_params' => [
                'client_id' => $api_key,
                'client_secret' => $api_secret,
                'code' => $code
            ]
        ]);
        $data = (array) json_decode($res_token->getBody());
        // dd($data);
        // dd($data['access_token']);
        $this->shop($data, $shop_name);
        
        
        
    }

    public function shop($data_token, $shop_name) 
    {
        $client = new Client();
        $uri = 'https://'.$shop_name.'/admin/api/2022-07/shop.json?';
        $resShop = $client->request('GET', $uri, [
            'headers' => [
                'X-Shopify-Access-Token' => $data_token['access_token'],
            ]
        ]);
        $res_shop = (array) json_decode($resShop->getBody());

        dd($res_shop);
    }
}
