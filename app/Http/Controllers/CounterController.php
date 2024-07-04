<?php

namespace App\Http\Controllers;

use App\Http\Requests\CounterRequest;
use App\Models\Counter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CounterController extends Controller
{
    
    public function index(Request $request) {
        
        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        try {

            // get all counters
            $counters = Counter::with(['counterManager' => function($query) { 
                $query->select('id', 'name'); 
            }])->get();
            
            // logging history
            Log::channel('CounterController')->info('Get all counters.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'counters' => $counters
            ], 200);

        } catch (\Exception $e) { 
            
            // logging history
            Log::channel('CounterController')->error('Something went wrong.', [ 'exception' => $e->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
    public function create(Request $request) {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        try {

            // get all counter managers
            $counterManagers = User::where('role', 2)->select("id", "name")->get();

            // logging history
            Log::channel('CounterController')->info('Get all counter managers.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'counterManagers' => $counterManagers
            ], 200);

        } catch (\Exception $e) {

            // logging history
            Log::channel('CounterController')->error('Something went wrong.', [ 'exception' => $e->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    public function store(CounterRequest $request) {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        // validation
        $request->validated();

        try { 

            Counter::create([
                'name' => $request->name,
                'counter_manager_id' => $request->counter_manager_id,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'status' => $request->status
            ]);

            // logging history
            Log::channel('CounterController')->info('Counter created successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Counter created successfully.'
            ], 200);

        } catch (\Exception $e) {

            // logging history
            Log::channel('CounterController')->error('Something went wrong.', [ 'exception' => $e->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    public function edit(Request $request, $id) {
        
        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        try {
            
            // get counter
            $counter = Counter::findOrFail($id);

            // get all counter managers
            $counterManagers = User::where('role', 2)->select("id", "name")->get();

            // logging history
            Log::channel('CounterController')->info('Get counter.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'counter' => $counter,
                'counterManagers' => $counterManagers
            ], 200);
        } catch (\Exception $e) {

            // logging history
            Log::channel('CounterController')->error('Something went wrong.', [ 'exception' => $e->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
    public function update(CounterRequest $request, $id) {
        
        if (Gate::denies('adminOrManager')) {
            abort(403);
        }

        // validation
        $request->validated();

        try {

            // get counter
            $counter = Counter::findOrFail($id);
            
            // update counter
            $counter->update([
                'name' => $request->name,
                'counter_manager_id' => $request->counter_manager_id,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'status' => $request->status
            ]);

            // logging history
            Log::channel('CounterController')->info('Counter updated successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Counter updated successfully.'
            ], 200);

        } catch (\Exception $e) { 

            // logging history
            Log::channel('CounterController')->error('Something went wrong.', [ 'exception' => $e->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);

        }
    }
    public function destroy(Request $request, $id) {

        if (Gate::denies('adminOrManager')) {
            abort(403);
        }
        
        try {

            // get counter
            $counter = Counter::findOrFail($id);

            // delete counter
            $counter->delete();

            // logging history
            Log::channel('CounterController')->info('Counter deleted successfully.', ['date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Counter deleted successfully.'
            ], 200);

        } catch (\Exception $e) {

            // logging history
            Log::channel('CounterController')->error('Something went wrong.', [ 'exception' => $e->getMessage() , 'date' => now(), 'method' => __METHOD__, 'user_ip' => $request->ip()]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
}
