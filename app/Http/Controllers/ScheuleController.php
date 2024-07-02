<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScheuleController extends Controller
{
    public function index() 
    {
        
        try {

            // get all schedules
            $schedules = Schedule::orderBy('id', 'desc')->get();

            // logging history
            Log::channel('ScheuleController')->info('Get all schedules.', ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'success',
                'schedules' => $schedules
            ]);
        } catch (Exception $e) {
            
            // logging history
            Log::channel('ScheuleController')->error('Something went wrong.', ['exception' => $e->getMessage(), 'date' => now(), 'method' => __METHOD__]);

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
            'start_time' => 'required | date_format:H:i',
            'end_time' => 'required | date_format:H:i',
        ]);
        try {

            // create new schedule
            Schedule::create($request->all());

            // logging history
            Log::channel('ScheuleController')->info('Create new schedule.', ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Schedule created successfully.'
            ]);
        } catch (Exception $ex) {
            
            // logging history
            Log::channel('ScheuleController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__]);

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
            // get schedule
            $schedule = Schedule::find($id);
            $schedule->delete();
            
            // logging history
            Log::channel('ScheuleController')->info('Delete schedule.', ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Schedule deleted successfully.'
            ]); 
        } catch (Exception $ex) {
            
            // logging history
            Log::channel('ScheuleController')->error($ex->getMessage(), ['date' => now(), 'method' => __METHOD__]);

            // return response
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong.'
            ]);
        }
    }
}
