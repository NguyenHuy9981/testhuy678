<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $product = $this->request;
        
        // Product::where('id_product_shopify', $product['id'])->update([
        //     'title' => $product['title'],
        //     'description' => $product['body_html'],
        //     'image' => isset($product['image']) && !empty($product['image']) ? $product['image']['src'] : null,
        //     'shop_name' => $product['vendor'],
        //     'id_product_shopify' => $product['id']
        // ]);
    }
}
