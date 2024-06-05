<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialiteLoginController extends Controller
{
    public function redirectToProvider($provider)
    {

        // validate provider
        if (is_null($provider) || !in_array($provider, ['google', 'linkedin'])) {

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid provider.'], 400);
        }
        try {

            // logging history
            Log::channel('SocialiteLoginController')->info('Redirecting to provider.', ['provider' => $provider, 'date' => now(), 'method' => __METHOD__, 'user_ip' => request()->ip()]);

            // redirect to provider
            return Socialite::driver($provider)->redirect();

        } catch (\Exception $e) {
            
            // logging history
            Log::channel('SocialiteLoginController')->error('Something went wrong.', ['exception' => $e->getMessage(), 'date' => now(), 'method' => __METHOD__, 'user_ip' => request()->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    public function handleProviderCallback($provider)
    {   

        // validate provider
        if (is_null($provider) || !in_array($provider, ['google', 'linkedin'])) {
            
            // logging history
            Log::channel('SocialiteLoginController')->info('Invalid provider.', ['provider' => $provider, 'date' => now(), 'method' => __METHOD__, 'user_ip' => request()->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid provider.'], 400);

        }

        try { 
            
            // get user from provider
            $userFromProvider = Socialite::driver($provider)->user();

            // find or create user
            $user = User::firstOrCreate([
                'email' => $userFromProvider->getEmail(),
            ], [
                'name' => $userFromProvider->getName(),
                'email' => $userFromProvider->getEmail(),
                'verified_at' => now(),
            ]);

            // create token
            $token = $user->createToken('auth_token')->plainTextToken;

            // logging history
            Log::channel('SocialiteLoginController')->info('User logged in successfully.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => request()->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully.',
                'token' => $token
            ]);

        } catch (\Exception $e) {
            
            // logging history
            Log::channel('SocialiteLoginController')->error('Something went wrong.', ['exception' => $e->getMessage(), 'date' => now(), 'method' => __METHOD__, 'user_ip' => request()->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong. Please try again.',
            ], 500);

        }
    }
}
