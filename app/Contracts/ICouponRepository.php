<?php

namespace App\Contracts;

use App\Models\Coupon;
use App\Http\Requests\CouponRequest;
use Illuminate\Database\Eloquent\Collection;



interface ICouponRepository
{
    /**
     * Get all coupon
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Store coupon
     *
     * @param CouponRequest
     * @return Coupon
     */
    public function store(CouponRequest $request): Coupon;

    /**
     * update specific coupon
     *
     * @param CouponRequest
     * @param Coupon
     * @return Coupon
     */
    public function update(CouponRequest $request, Coupon $coupon): Coupon;

    /**
     * delete specific coupon
     *
     * @param Coupon
     */
    public function delete(Coupon $coupon);


}
