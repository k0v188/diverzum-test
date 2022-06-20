<?php

namespace App\Models;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ActivatedCoupon extends Model
{
    protected $guarded = [];

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
