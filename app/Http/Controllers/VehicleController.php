<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    public function index(Request $request) 
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        try {

            // get all vehicle types
            $vehicles = Vehicle::all();
            
            // logging history
            Log::channel('VehicleController')->info('Get all vehicles.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'vehicles' => $vehicles
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function store(VehicleRequest $request) 
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        //validation
        $request->validated();

        try {

            // create new vehicle type
            Vehicle::create([
                'vehicle_name' => $request->vehicle_name,
                'vehicle_type_id' => $request->vehicle_type_id,
                'registration_number' => $request->registration_number,
                'chasis_number' => $request->chasis_number,
                'engine_number' => $request->engine_number,
                'model' => $request->model,
                'owner_name' => $request->owner_name,
                'owner_phone' => $request->owner_phone,
                'brand_name' => $request->brand_name,
                'status' => $request->status,
            ]);

            // logging history
            Log::channel('VehicleController')->info('Create new vehicle.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle created successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }


    }

    public function edit(Request $request, $id) 
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        try {

            // get vehicle type
            $vehicles = Vehicle::findOrFail($id);
            $vehicleTypes = VehicleType::where('id', '!=', $vehicles->vehicle_type_id)->select('id', 'name', 'slug')->get();

            // logging history
            Log::channel('VehicleController')->info('edit vehicle.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'vehicle' => $vehicles,
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

    public function update(VehicleRequest $request, $id) 
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        // validation
        $request->validated();

        try {

            // get vehicle type
            $vehicleType = Vehicle::findOrFail($id);

            // update vehicle type
            $vehicleType->update([
                'vehicle_name' => $request->vehicle_name,
                'vehicle_type_id' => $request->vehicle_type_id,
                'registration_number' => $request->registration_number,
                'chasis_number' => $request->chasis_number,
                'engine_number' => $request->engine_number,
                'model' => $request->model,
                'owner_name' => $request->owner_name,
                'owner_phone' => $request->owner_phone,
                'brand_name' => $request->brand_name,
                'status' => $request->status,
            ]);

            // logging history
            Log::channel('VehicleController')->info('Vehicle updated successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle  updated successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }
        
        try {

            // get vehicle type
            $vehicleType = Vehicle::findOrFail($id);

            // delete vehicle type
            $vehicleType->delete();

            // logging history
            Log::channel('VehicleController')->info('Vehicle deleted successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle deleted successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('VehicleController ')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
