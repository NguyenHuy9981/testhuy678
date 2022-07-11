<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'title',
        'description',
        'image',
        'id_product_shopify',
        'shop_name'
    ];

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'id_product_shopify');
    }
}
