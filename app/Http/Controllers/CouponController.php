<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Contracts\ICouponRepository;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource;

class CouponController extends Controller
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
     * Display all coupons.
     *
     * @return CouponResource
     */
    public function index()
    {
        return CouponResource::collection($this->couponRepository->getAll());
    }

    /**
     * Store a newly created coupon.
     *
     * @param CouponRequest
     * @return Coupon
     */
    public function store(CouponRequest $request)
    {
        return $this->couponRepository->store($request);
    }

    /**
     * Update the specific coupon.
     *
     * @param CouponRequest
     * @param Coupon
     * @return Coupon
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        return $this->couponRepository->update($request, $coupon);
    }

    /**
     * Remove the specified coupon.
     *
     * @param Coupon
     */
    public function destroy(Coupon $coupon)
    {
        return $this->couponRepository->delete($coupon);
    }
}
