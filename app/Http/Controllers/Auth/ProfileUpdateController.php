<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    public function updateProfile(ProfileUpdateRequest $request, $id)
    {

        $request->validated();

        try {
            
            // find or fail
            $user = User::findOrFail($id);

            // photo upload
            if ($request->hasFile('photo')) {

                //delete old photo
                if ($request->has('old_photo')) {
                    Storage::disk('public')->delete($request->old_photo);
                }

                $photo = $request->file('photo');
                $photo = Storage::disk('public')->put('/', $photo);
            }
            
            // cv upload
            if ($request->hasFile('cv')) {

                //delete old cv
                if ($request->has('old_cv')) {
                    Storage::disk('local')->delete($request->old_cv);
                }

                $cv = $request->file('cv');
                $cv = Storage::disk('local')->put('/', $cv);
            }

            // update user info
            User::where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            // update profile info
            Profile::where('user_id', $user->id)->update([
                'gender' => $request->gender,
                'photo' => $photo?? $request->old_photo,
                'cv' => $cv?? $request->old_cv,
                'phone' => $request->phone,
                'em_phone' => $request->em_phone,
                'country' => $request->country,
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip,
                'discription' => $request->discription,
            ]);

            // logging history
            Log::channel('ProfileUpdateController')->info('Update profile info.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated.'], 200);

        } catch (\Exception $e) { 

            // logging history
            Log::channel('ProfileUpdateController')->error('Failed to update profile info.', ['exception' => $e->getMessage(), 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to update profile info.'], 500);
                
        }
    }
}
