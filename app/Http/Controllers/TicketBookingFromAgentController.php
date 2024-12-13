<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;

class TicketBookingFromAgentController extends Controller
{
    
    public function index()
    {

        try {

            // get Trip route

            $trips = TripRoute::where('status', 1)->select('id', 'route_name', 'starting_point', 'destination_point')->get();

            // logging history

            Log::channel('TicketBookingFromAgentController')->info('Get all trips for ticket booking', ['date' => now(), 'method' => __METHOD__]);

            // return response

            return response()->json([
                'status' => 'success',
                'trips' => $trips
            ], 200);
        } catch (\Exception $e) {

            // logging history

            Log::channel('TicketBookingFromAgentController')->error($e->getMessage(), ['date' => now(), 'method' => __METHOD__]);

            // return response

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.'
            ], 500);
        }

    }

    public function findTrips(Request $request, TripRoute $trip)
    {

        // validation

        $request->validate([
            'route_name' => 'required',
            'starting_point' => 'required',
            'destination_point' => 'required',
        ]);

        try {

            // get Trip route
            
            $tripRoute = TripRoute::with([
                "trips" => function ($query) use ($request) {
                    $query->select('id', 'trip_route', 'schedule', 'vehicle_list', 'vehicle_type', 'driver_list');
                }
            ])->where('route_name', $request->route_name)
              ->where('starting_point',  $request->starting_point)
              ->where('destination_point', $request->destination_point)
              ->select('id', 'route_name', 'starting_point', 'destination_point', 'distance', 'duration')->get();


            // logging history

            Log::channel('TicketBookingFromAgentController')->info('Get all trips for ticket booking', ['date' => now(), 'method' => __METHOD__]);

            // return response

            return response()->json([
                'status' => 'success',
                'tripRoute' => $tripRoute
            ], 200);
        } catch (\Exception $e) {

            // logging history

            Log::channel('TicketBookingFromAgentController')->error($e->getMessage(), ['date' => now(), 'method' => __METHOD__]);

            // return response

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.'
            ], 500);
        }
    }
}
