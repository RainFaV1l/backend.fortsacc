<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;

class AuthController extends Controller
{
    function register(RegisterRequest $request)
    {

        $token = DB::transaction(function () use ($request) {

            $data = $request->validated();

            $user = User::query()->create($data);

            $user->update([
                'referral_link' => Hashids::encode($user->id)
            ]);

            return $user->createToken($data['first_name'])->plainTextToken;

        }, 5);

        return response()->json(['token' => $token]);
    }

    function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->where('email', $data['email'])->firstOrFail();

        if(!auth()->attempt($data)) return response()->json(['error' => 'Unauthorized'], 401);

        $token = $user->createToken($user['first_name'])->plainTextToken;

        return response()->json(['token' => $token]);
    }

    function user()
    {
        return new UserResource(request()->user());
    }

    function logout()
    {
        $user = request()->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'Logged out']);
    }

}