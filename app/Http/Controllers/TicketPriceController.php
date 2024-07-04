<?php

namespace App\Http\Controllers;

use App\Models\TicketPrice;
use App\Models\TripRoute;
use App\Models\VehicleType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Ticket;

class TicketPriceController extends Controller
{
    public function index(Request $request) 
    {
        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        try {

            // get all ticket price
            $ticketPrice = TicketPrice::with([
                "vehicleType" => function ($query) { $query->select('id', 'name', 'has_ac'); },
                "tripRoute" => function ($query) { $query->select('id', 'route_name'); }
                ])->get();
            
            // logging history
            Log::channel('TicketPriceController')->info('Get all ticket price.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'ticketPrice' => $ticketPrice
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TicketPriceController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

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

            // get all type of vehicle
            $vehicleTypes = VehicleType::where('status', 1)->select('id', 'name', 'has_ac')->get();

            // get all trip route
            $tripRoute = TripRoute::where('status', 1)->select('id', 'route_name')->get();
            
            // logging history
            Log::channel('TicketPriceController')->info('create ticket price.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'vehicleTypes' => $vehicleTypes,
                'tripRoute' => $tripRoute
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TicketPriceController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

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
            'vehicle_type_id' => 'required',
            'trip_route_id' => 'required',
            'price' => 'required',
        ]);

        try {

            // create new ticket price
            TicketPrice::create($request->all());

            // logging history
            Log::channel('TicketPriceController')->info('Ticket price created.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Ticket price created successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TicketPriceController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

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

            // get ticket price
            $ticket = TicketPrice::where('id', $id)->get();

            // get all type of vehicle
            $vehicleTypes = VehicleType::where('status', 1)->select('id', 'name', 'has_ac')->get();

            // get all trip route
            $tripRoute = TripRoute::where('status', 1)->select('id', 'route_name')->get();

            // logging history
            Log::channel('TicketPriceController')->info('edit ticket price.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'ticket' => $ticket,
                'vehicleTypes' => $vehicleTypes,
                'tripRoute' => $tripRoute
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TicketPriceController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

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
            'vehicle_type_id' => 'required',
            'trip_route_id' => 'required',
            'price' => 'required',
        ]);

        try {

            // get ticket price
            $ticketPrice = TicketPrice::findOrFail($id);

            // update trip route
            $ticketPrice->update($request->all());

            // logging history
            Log::channel('TicketPriceController')->info('Ticket price updated successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Ticket price updated successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TicketPriceController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

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
            $ticketPrice = TicketPrice::findOrFail($id);

            // delete trip route
            $ticketPrice->delete();

            // logging history
            Log::channel('TicketPriceController')->info('Ticket price deleted successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Ticket price deleted successfully.'
            ], 200);
        } catch (Exception $ex) {

            // logging history
            Log::channel('TicketPriceController ')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
