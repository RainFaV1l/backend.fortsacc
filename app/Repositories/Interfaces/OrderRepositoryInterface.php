<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function createUser(array $data) : \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model | null;
    public function generateReferralLink(\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $user) : void;
    public function createOrder(array $data) : array | null;

    public function discount(float $price, int $couponId) : float;

    public function getTotalPrice(object $products) : float;
    public function storeProducts(object $products, object $cart) : void;
}
