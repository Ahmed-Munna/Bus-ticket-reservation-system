<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Exception;
use App\Http\Controllers\Controller;
use App\Jobs\SendOtpJob;
use App\Mail\ForgotPasswordOtpMail;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validate request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        try {

            // create user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // get user data from database
            $user = User::where('email', $request->email)->first();

            // create profile
            Profile::create([
                'user_id' => $user->id
            ]);

            // create token
            $token = $user->createToken('auth_token')->plainTextToken;

            // logging history
            Log::channel('AuthController')->info('User created successfully.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully.', 
                'token' => $token], 201);

        } catch (Exception $ex) {

            // logging history
            Log::channel('AuthController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);
            
            // return response
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, please try again."], 500);
        }
    }

    public function login(Request $request)
    {
        // validate request
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {   
            
            // find user
            $user = User::where('email', $request->email)->first();

            // authenticate user
            if (! $user || ! Hash::check($request->password, $user->password)) {

                // logging history
                Log::channel('AuthController')->info('The provided credentials are incorrect.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

                // return response
                return response()->json([
                    'status' => 'failed',
                    'message' => 'The provided credentials are incorrect.'], 401);

            }

            // create token
            $token = $user->createToken('auth_token')->plainTextToken;

            // logging history
            Log::channel('AuthController')->info('User logged in successfully.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully.', 
                'token' => $token], 200);

        } catch (Exception $ex) {

            // logging history
            Log::channel('AuthController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, please try again."], 500);
        }
    }   

    public function sendOtp(Request $request) 
    {

        // validate request
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        try {

            // find user
            $user = User::where('email', $request->email)->first();

            // authenticate user
            if (! $user) {

                // logging history
                Log::channel('AuthController')->info('User not found.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

                // return response
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not found.'], 404);

            }

            // send otp
            $otp = rand(1000, 9999);

            // update otp
            $user->update([
                'otp' => $otp
            ]);

            // dispatch job
            SendOtpJob::dispatch($user->email,$otp)->onQueue('high');

            // logging history
            Log::channel('AuthController')->info('OTP sent successfully.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully.'], 200);

        } catch (Exception $ex) {

            // logging history
            Log::channel('AuthController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, please try again."], 500);

        }
    }

    public function verifyOtp(Request $request)
    {
        // validate request
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'otp' => ['required', 'string'],
        ]);

        try {

            // find user
            $user = User::where('email', $request->email)->first();

            // authenticate user
            if (! $user) {

                // logging history
                Log::channel('AuthController')->info('User not found.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

                // return response
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not found.'], 404);

            }

            // authenticate otp
            if ($user->otp != $request->otp) {

                // logging history
                Log::channel('AuthController')->info('Invalid OTP.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

                // return response
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid OTP.'], 401);

            }

            // update otp
            $user->update([
                'otp' => null
            ]);

            // create token
            $token = $user->createToken('auth_token')->plainTextToken;

            // logging history
            Log::channel('AuthController')->info('OTP verified successfully.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully.',
                'token' => $token
            ], 200);

        } catch (Exception $ex) {

            // logging history
            Log::channel('AuthController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, please try again."], 500);

        }
    }

    public function resetPassword(Request $request) 
    {
        // validate request
        $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        try {

            // find user
            $user = Auth::id();

            // update password
            User::where('id', $user)->update([
                'password' => bcrypt($request->password)
            ]);

            // logging history
            Log::channel('AuthController')->info('Password reset successfully.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully.'], 200);
                

        } catch (Exception $ex) {

            // logging history
            Log::channel('AuthController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, please try again."], 500);
        }
    }

    public function logout(Request $request)
    {

        try {

            // delete token
            $request->user()->currentAccessToken()->delete();

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully.'], 200);

        } catch (Exception $ex) {

            // logging history
            Log::channel('AuthController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, please try again."], 500);

        }
    }
}
