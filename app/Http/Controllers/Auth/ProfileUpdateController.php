<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ProfileUpdateController extends Controller
{
    public function index(Request $request)
    {
        
        try {

            // get profile info from database
            $user = User::with(["profile" => function ($query) {
                $query->select("id", "user_id", "gender", "photo","phone", "em_phone", "country", "address", "city", "zip", "discription");
            }])->find(Auth::id());


            return $user;
            // logging history
            Log::channel('ProfileUpdateController')->info('Get profile info.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'data' => $user], 200);

        } catch (\Exception $e) { 

            // logging history
            Log::channel('ProfileUpdateController')->error('Failed to get profile info.', ['exception' => $e->getMessage(), 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to get profile info.'], 500);

        }

    }

    public function update(ProfileUpdateRequest $request)
    {

        try {

            // photo upload
            // if ($request->hasFile('photo')) {

            //     $photo = $request->file('photo');
            //     $photoName = time() . '.' . $photo->getClientOriginalExtension();
            //     $photo->move(public_path('storage/profile'), $photoName);
            // }
            
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoName = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('storage/profile'), $photoName);
                $request->merge(['photo' => $photoName]);
            }

            // update user info
            User::where('id', Auth::id())->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            // update profile info
            Profile::where('user_id', Auth::id())->update([
                'gender' => $request->gender,
                'photo' => $request->photo,
                'cv' => $request->cv,
                'phone' => $request->phone,
                'em_phone' => $request->em_phone,
                'country' => $request->country,
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip,
                'discription' => $request->discription,
            ]);

        } catch (\Exception $e) { 

        }
    }
}
