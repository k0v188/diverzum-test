<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\ICouponRepository;
use App\Http\Resources\ActivatedCouponResource;

class ActivatedCouponController extends Controller
{
    /**
     * Coupon repository
     *
     * @var ICouponRepository
     */
    private $couponRepository;

    public function __construct(ICouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }
    
    /**
     * get all activated coupons.
     *
     * @return ActivatedCouponResource
     */
    public function __invoke()
    {
        return ActivatedCouponResource::collection($this->couponRepository->getAllActivatedCoupon());
    }
}
