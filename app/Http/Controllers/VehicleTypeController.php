<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleTypeRequest;
use App\Models\VehicleType;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleTypeController extends Controller
{
    
    public function index(Request $request) 
    {

        try {

            // get all vehicle types
            $vehicleTypes = VehicleType::all();
            
            // logging history
            Log::channel('VehicleTypeController')->info('Get all vehicle types.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'vehicleTypes' => $vehicleTypes
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleTypeController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function store(VehicleTypeRequest $request) 
    {

        //validation
        $request->validated();

        try {

            // create new vehicle type
            VehicleType::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'seat_layout' => $request->seat_layout,
                'number_of_seats' => $request->number_of_seats,
                'seat_number' => $request->seat_number,
                'status' => $request->status,
                'has_ac' => $request->has_ac,
            ]);

            // logging history
            Log::channel('VehicleTypeController')->info('Create new vehicle type.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle type created successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleTypeController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }


    }

    public function edit(Request $request, $id) 
    {

        try {

            // get vehicle type
            $vehicleType = VehicleType::findOrFail($id);

            // logging history
            Log::channel('VehicleTypeController')->info('Get vehicle type.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'vehicleType' => $vehicleType
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleTypeController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update(VehicleTypeRequest $request, $id) 
    {

        // validation
        $request->validated();

        try {

            // get vehicle type
            $vehicleType = VehicleType::findOrFail($id);

            // update vehicle type
            $vehicleType->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'seat_layout' => $request->seat_layout,
                'number_of_seats' => $request->number_of_seats,
                'seat_number' => $request->seat_number,
                'status' => $request->status,
                'has_ac' => $request->has_ac,
            ]);

            // logging history
            Log::channel('VehicleTypeController')->info('Vehicle type updated successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle type updated successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleTypeController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {

            // get vehicle type
            $vehicleType = VehicleType::findOrFail($id);

            // delete vehicle type
            $vehicleType->delete();

            // logging history
            Log::channel('VehicleTypeController')->info('Vehicle type deleted successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle type deleted successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleTypeController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
