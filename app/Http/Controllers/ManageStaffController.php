<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ManageStaffController extends Controller
{

    public function showAllAreaManagers(Request $request) {

        try {

            // get all area managers
            $users = User::with('profile')->where('role', 2)->get();

            // logging history
            Log::channel('ManageStaffController')->info('Get all area managers.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'data' => $users
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('ManageStaffController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
    
    public function showAllCounterManagers(Request $request) {

        try {

            // get all counter managers
            $users = User::with('profile')->where('role', 3)->get();

            // logging history
            Log::channel('ManageStaffController')->info('Get all counter managers.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'data' => $users
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('ManageStaffController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    public function showAllDrivers(Request $request) {

        try {

            // get all counter managers
            $users = User::with('profile')->where('role', 4)->get();

            // logging history
            Log::channel('ManageStaffController')->info('Get all drivers.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'data' => $users
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('ManageStaffController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
    
    public function store(ManageStaffRequest $request) 
    {
        
        $request->validated();

        try {

            // create user
            User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role
            ]);

            // get profile info from database

            $getUserId = User::where('email', $request->email)->first();

            // photo upload
            if ($request->hasFile('photo')) {

                $photo = $request->file('photo');
                $photo = Storage::disk('public')->put('/', $photo);
            }
            
            // cv upload
            if ($request->hasFile('cv')) {

                $cv = $request->file('cv');
                $cv = Storage::disk('local')->put('/', $cv);
            }
            
            // update profile
            Profile::where('user_id', $getUserId->id)->update([
                'gender' => $request->gender,
                'photo' => $photo?? null,
                'cv' => $cv?? null,
                'phone' => $request->phone,
                'em_phone' => $request->em_phone,
                'country' => $request->country,
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip,
                'discription' => $request->discription
            ]);

            // logging history
            Log::channel('ManageStaffController')->info('Create new staff.', ['user' => $getUserId, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Staff created successfully.',
            ], 201);

        } catch (Exception $ex) {
            
            // logging history
            Log::channel('ManageStaffController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    public function update(UpdateStaffRequest $request, $id) 
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
                'email' => $request->email,
                'password' => $request->password?? bcrypt($request->password),
            ]);

            // update profile info
            Profile::where('user_id', $user->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
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
            Log::channel('ManageStaffController')->info('Update staff.', ['user' => $user, 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Staff updated successfully.',
            ], 200);

        } catch (Exception $ex) {

            // logging history
            Log::channel('ManageStaffController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    public function destroy(Request $request, $id) 
    {

        try {

            // find or fail
            $user = User::findOrFail($id);
            $profile = Profile::where('user_id', $user->id)->first();
            
            // delete photo
            if ($profile->photo) {
                
                Storage::disk('public')->delete($profile->photo);
            }

            // delete cv
            if ($profile->cv) {

                Storage::disk('local')->delete($profile->cv);
            }

            // delete user
            $user->delete();

            // logging history
            Log::channel('ManageStaffController')->info('Delete staff.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Staff deleted successfully.',
            ], 200);

        } catch (Exception $ex) {

            // logging history
            Log::channel('ManageStaffController')->error('Something went wrong.', [ 'exception' => $ex->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
}
