<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::all();

        return CouponResource::collection($coupons);
    }

    /**
     * @param Coupon $coupon
     * @return CouponResource
     */
    public function check(CouponRequest $request)
    {
        $data = $request->validated();

        $coupon = Coupon::query()->where('name', $data['name'])->where('expired_at', '>', Carbon::now())->firstOrFail();

        return new CouponResource($coupon);
    }
}
