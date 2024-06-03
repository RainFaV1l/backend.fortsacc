<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserReferral;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Vinkla\Hashids\Facades\Hashids;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $token = DB::transaction(function () use ($request) {

            $data = $request->validated();

            $referral = $data['referral'] ?? null;

            unset($data['referral']);

            $user = User::query()->create($data);

            $user->update([
                'referral_link' => Hashids::encode($user->id)
            ]);

            if(!is_null($referral)) {

                $referrer = User::query()->where('referral_link', $referral)->firstOrFail();

                UserReferral::query()->create([
                    'referral_id' => $user->id,
                    'user_id' => $referrer->id,
                    'referral_code' => $referral,
                ]);

            }

            return $user->createToken($data['first_name'])->plainTextToken;

        }, 5);

        return response()->json(['token' => $token]);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if(!auth()->attempt($data)) return response()->json(['error' => 'Unauthorized'], 401);

        $token = auth()->user()->createToken(auth()->user()->first_name)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function user()
    {
        return new UserResource(request()->user());
    }

    public function logout()
    {
        $user = request()->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'Logged out']);
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['github', 'google']))
            return response()->json(['error' => 'Please login using github or google'], 422);
    }

    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);

        if (!is_null($validated)) return $validated;

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function findOrCreateUser($user)
    {
        return User::query()->firstOrCreate([
            'first_name' => $user->name,
            'last_name' => $user->bio,
            'email' => $user->email,
        ]);
    }

    public function handleProviderCallback($provider)
    {
        $validated = $this->validateProvider($provider);

        if (!is_null($validated)) return $validated;

        try {

            $user = Socialite::driver($provider)->stateless()->user();

        } catch (\Exception $e) {

            return response()->json(['error' => 'Invalid credentials provided.'], 422);

        }

        $authUser = $this->findOrCreateUser($user);

        $authUser->providers()->updateOrCreate([
            'provider' => $provider,
            'provider_id' => $authUser->id,
        ]);

        $token = $authUser->createToken($authUser['first_name'])->plainTextToken;

//        return response()->json($authUser, 200, ['Access-Token' => $token]);

        return redirect()->to('http://localhost:5173/oauth/callback/' . $token);
    }

}
