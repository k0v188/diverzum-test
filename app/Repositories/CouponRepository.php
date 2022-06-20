<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Contracts\ICouponRepository;
use App\Http\Requests\CouponRequest;
use Illuminate\Database\Eloquent\Collection;


class CouponRepository implements ICouponRepository
{
    public function getAll(): Collection
    {
        return Coupon::all();
    }

    public function store(CouponRequest $request): Coupon
    {
        return Coupon::create(
            $request->all() + ['expire_time' => Carbon::now()]
        );
    }

    public function update(CouponRequest $request, Coupon $coupon): Coupon
    {
        $coupon->update(
            $request->all() + ['expire_time' => Carbon::now()]
        );

        return $coupon;
    }

    public function delete(Coupon $coupon)
    {
        $coupon->delete();
    }

}
