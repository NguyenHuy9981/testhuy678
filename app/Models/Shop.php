<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'email',
        'shopify_domain',
        'access_token',
        'plan_display_name',
        'plan_name',
        'shop_created_at',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_name', 'name');
    }
}
