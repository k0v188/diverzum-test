<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\CouponHelper;
use App\Contracts\ICouponRepository;
use App\Contracts\IProductRepository;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\CheckCouponRequest;

class CheckCouponController extends Controller
{
    /**
     * Product repository
     *
     * @var IProductRepository
     */
    private $productRepository;

    /**
     * Coupon repository
     *
     * @var ICouponRepository
     */
    private $couponRepository;

    public function __construct(IProductRepository $productRepository, ICouponRepository $couponRepository)
    {
        $this->productRepository = $productRepository;
        $this->couponRepository = $couponRepository;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\CheckCouponRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CheckCouponRequest $request)
    {
        $product = $this->productRepository->find($request->product_id);

        if (!$product->coupon->active) {
            return Response::json(array(
                'code'      =>  400,
                'errors'   =>  ['coupon' => ['Ez a kupon már nem érvényes']]
            ), 400);
        }

        if ($product->coupon->code != $request->coupon) {
            return Response::json(array(
                'code'      =>  404,
                'errors'   =>  ['coupon' => ['A kuponkód nem található']]
            ), 404);
        }

        if ($product->coupon->expire_time > Carbon::now()) {
            return Response::json(array(
                'code'      =>  400,
                'errors'   =>  ['coupon' => ['Ezt a kupon csak 1 perc múlva használhatod fel újra']]
            ), 400);
        }

        if ($product->coupon->type == 'custom') {
            $product->coupon()->update([
                'code' => CouponHelper::generateCouponCode(),
                'expire_time' => Carbon::now()->addMinute()
            ]);
        } else {
            $product->coupon()->update([
                'expire_time' => Carbon::now()->addMinute()
            ]);
        }

        $this->couponRepository->activate($product->coupon, $product);

        return Response::json(array(
            'code'      =>  200,
            'message'   =>  'A kupon beváltásra került'
        ), 200);

    }
}
