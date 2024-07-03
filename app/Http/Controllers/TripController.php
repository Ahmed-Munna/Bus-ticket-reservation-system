<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Trip;
use App\Models\TripRoute;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
{
    
    public function index()
    {
        try {

            // get all trips

            $trips = Trip::with([
                "VehicleType" => function ($query) {
                    $query->select('id', 'name', 'slug');
                },

                "TripRoute" => function ($query) {
                    $query->select('id', 'route_name', 'starting_point', 'destination_point', 'distance', 'duration');
                },

                "Schedule" => function ($query) {
                    $query->select('id', 'start_time', 'end_time');
                },

                "driver" => function ($query) {
                    $query->select('id', 'name');
                },

                "vehicle" => function ($query) {
                    $query->select('id', 'vehicle_name');
                }
            ])->get();
            
            // logging history
            Log::channel('TripController')->info('Get all trips.', ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'success',
                'trips' => $trips
            ]);
        } catch (Exception $e) {
            
            // logging history
            Log::channel('TripController')->error('Something went wrong.', ['exception' => $e->getMessage(), 'date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function create(Request $request) 
    {
        try {
            
            // get trip route

            $tripRoute = TripRoute::select('id', 'route_name', 'starting_point', 'destination_point', 'distance', 'duration')->get();

            // get all type of vehicle

            $vehicleTypes = VehicleType::where('status', 1)->select('id', 'name', 'slug', 'has_ac')->get();

            // get all vehicle

            $vehicles = Vehicle::where('status', 1)->select('id', 'vehicle_name','vehicle_type_id')->get();

            // schedule

            $schedules = Schedule::all();

            // get all driver

            $drivers = User::where('role', 4)->select('id', 'name')->get();

            // logging history

            Log::channel('TripController')->info('Create new trip.', ['date' => now(), 'method' => __METHOD__]);

            // return response

            return response()->json([
                'status' => 'success',
                'tripRoute' => $tripRoute,
                'vehicleTypes' => $vehicleTypes,
                'vehicles' => $vehicles,
                'schedules' => $schedules,
                'drivers' => $drivers
            ]);
        } catch (Exception $ex) {

            // logging history

            Log::channel('TripController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__]);

            // return response

            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function store(Request $request)
    {

        //validation
        $request->validate([
            'trip_route' => 'required | string',
            'vehicle_type' => 'required | string',
            'vehicle_list' => 'required | string',
            'schedule' => 'required | string',
            'driver_list' => 'required | string',
            'status' => 'boolean'
        ]);

        try {   

            // create new trip
            Trip::create($request->all());

            // logging history
            Log::channel('TripController')->info('Create new trip.', ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Trip created successfully.'
            ]);

        } catch (Exception $ex) {

            // logging history
            Log::channel('TripController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function edit($id)
    {

        try {
            
            // get trip
            $trip = Trip::where('id', $id)->select('id', 'trip_route', 'vehicle_type', 'vehicle_list', 'schedule', 'driver_list', 'status')->first();

            // get trip route

            $tripRoute = TripRoute::select('id', 'route_name', 'starting_point', 'destination_point', 'distance', 'duration')->get();

            // get all type of vehicle

            $vehicleTypes = VehicleType::where('status', 1)->select('id', 'name', 'slug', 'has_ac')->get();

            // get all vehicle

            $vehicles = Vehicle::where('status', 1)->select('id', 'vehicle_name','vehicle_type_id')->get();

            // schedule

            $schedules = Schedule::all();

            // get all driver

            $drivers = User::where('role', 4)->select('id', 'name')->get();

            // logging history
            Log::channel('TripController')->info('Edit trip.', ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'success',
                'trip' => $trip,
                'tripRoute' => $tripRoute,
                'vehicleTypes' => $vehicleTypes,
                'vehicles' => $vehicles,
                'schedules' => $schedules,
                'drivers' => $drivers
            ]);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TripController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        
        //validation
        $request->validate([
            'trip_route' => 'required | string',
            'vehicle_type' => 'required | string',
            'vehicle_list' => 'required | string',
            'schedule' => 'required | string',
            'driver_list' => 'required | string',
            'status' => 'boolean'
        ]);

        try {

            // update trip
            Trip::where('id', $id)->update($request->all());

            // logging history
            Log::channel('TripController')->info('Update trip.', ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Trip updated successfully.'
            ]);

        } catch (Exception $ex) {

            // logging history
            Log::channel('TripController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function destroy($id)
    {

        try {

            // get trip

            $trip = Trip::where('id', $id)->first();

            // delete trip

            $trip->delete();

            // logging history

            Log::channel('TripController')->info('Delete trip.', ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Trip deleted successfully.'
            ]);

        } catch (Exception $ex) {

            // logging history
            Log::channel('TripController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.'
            ]);
        }
    }
}
