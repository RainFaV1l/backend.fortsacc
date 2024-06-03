<?php

namespace App\Repositories;

use App\Mail\SendPassword;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class OrderRepository implements OrderRepositoryInterface
{
    public function generateReferralLink($user): void
    {
        $user->update([
            'referral_link' => Hashids::encode($user->id)
        ]);
    }

    public function createUser(array $data): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        $password = Str::random(8);

        $user = User::query()->firstOrCreate([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $password,
        ]);

        Mail::to($user->email)->send(new SendPassword($password));

        return $user;
    }

    public function discount(float $price, int $couponId) : float
    {
        $coupon = Coupon::query()->findOrFail($couponId);

        return $price * ((100 - $coupon->percent) / 100);
    }

    public function createOrder(array $data): array|null
    {
        return DB::transaction(function () use ($data) {

            if(!is_null(request()->user())) $user = request()->user();

            else $user = $this->createUser($data);

            $this->generateReferralLink($user);

            $data['user_id'] = $user->id;

            $products = collect($data['products']);

            unset($data['products']);

            $data['total'] = $this->getTotalPrice($products);

            if($data['coupon_id']) $data['total'] = $this->discount($data['total'], $data['coupon_id']);

            $cart = Cart::query()->create($data);

            $this->storeProducts($products, $cart);

            if(!is_null(request()->user())) return $cart;

            else return [
                'cart' => $cart,
                'token' => $user->createToken($data['first_name'])->plainTextToken,
            ];

        }, 3);
    }

    public function getTotalPrice(object $products): float
    {
        return $products->sum(function (array $product) {

            $productPrice = Product::query()->findOrFail($product['id']);

            return $productPrice['price'] * $product['count'];

        });
    }

    public function storeProducts(object $products, object $cart): void
    {
        $products->each(function (array $product, int $key) use ($cart) {
            Order::query()->create([
                'cart_id' => $cart->id,
                'product_id' => $product['id'],
                'count' => $product['count'],
            ]);
        });
    }
}
