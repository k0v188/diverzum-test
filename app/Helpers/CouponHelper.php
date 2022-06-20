<?php

namespace App\Helpers;

class CouponHelper
{
    static function generateCouponCode(): string
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $coupon = "";
        for ($i = 0; $i < 10; $i++) {
            $coupon .= $characters[mt_rand(0, strlen($characters)-1)];
        }

        return $coupon;
    }
}
