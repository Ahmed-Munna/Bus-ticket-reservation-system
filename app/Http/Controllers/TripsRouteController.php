<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\TripRoute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TripsRouteController extends Controller
{
    public function index(Request $request) 
    {
        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        try {

            // get all vehicle types
            $TripRoutes = TripRoute::all();
            
            // logging history
            Log::channel('TripsRouteController')->info('Get all trips routes.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'routes' => $TripRoutes
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TripsRouteController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function create(Request $request) 
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        try {

            // get all counters
            $TripCounters = Counter::where('status', 1)->select('id', 'name', 'city')->get();
            
            // logging history
            Log::channel('TripsRouteController')->info('Get all counter.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'counters' => $TripCounters
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TripsRouteController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function store(Request $request) 
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        //validation
        $request->validate([
            'route_name' => 'required', 'string', 'max:255',
            'starting_point' => 'required', 'string', 'max:255',
            'destination_point' => 'required', 'string', 'max:255',
            'distance' => 'required', 'string', 'max:50',
            'duration' => 'required', 'string', 'max:50',
            'status' => 'boolean'
        ]);

        try {

            // create new trips route
            TripRoute::create($request->all());

            // logging history
            Log::channel('TripsRouteController')->info('Create trip route.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Trip route created successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TripsRouteController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

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
            $routes = TripRoute::findOrFail($id);
            $counter = Counter::where('status', 1)->select('id', 'name')->get();

            // logging history
            Log::channel('TripsRouteController')->info('edit trip route.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'routes' => $routes,
                'counter' => $counter
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TripsRouteController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id) 
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        //validation
        $request->validate([
            'route_name' => 'required', 'string', 'max:255',
            'starting_point' => 'required', 'string', 'max:255',
            'destination_point' => 'required', 'string', 'max:255',
            'distance' => 'required', 'string', 'max:50',
            'duration' => 'required', 'string', 'max:50',
            'status' => 'boolean'
        ]);

        try {

            // get trip route
            $tripRoute = TripRoute::findOrFail($id);

            // update trip route
            $tripRoute->update([
                'route_name' => $request->route_name,
                'starting_point' => $request->starting_point,
                'destination_point' => $request->destination_point,
                'distance' => $request->distance,
                'duration' => $request->duration,
                'status' => $request->status,
            ]);

            // logging history
            Log::channel('TripsRouteController')->info('Trips Route updated successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Trip route  updated successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TripsRouteController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request ,$id) 
    {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }
        
        try {

            // get trip route
            $tripRoute = TripRoute::findOrFail($id);

            // delete trip route
            $tripRoute->delete();

            // logging history
            Log::channel('TripsRouteController')->info('Trip route deleted successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Route deleted successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TripsRouteController ')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
