<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = Cart::query()->where('user_id', auth('sanctum')->user()->id)->get();

        return CartResource::collection($orders);
    }

    public function lastOrders()
    {
        $orders = Cart::query()->where('user_id', auth('sanctum')->user()->id)->orderByDesc('created_at')->take(3)->get();

        return CartResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $storeRequest)
    {
        $data = $storeRequest->validated();

        if(!is_null(auth('sanctum')->user())) {

            $user = auth('sanctum')->user();

            $data = $this->orderRepository->createOrder($data, $user);

        } else {

            $data = $this->orderRepository->createOrder($data);

        }

        if(isset($data['token'])) return response()->json([
            'token' => $data['token'],
            'cart' => new CartResource($data['cart']),
        ]);

        else return new CartResource($data);
    }
}
