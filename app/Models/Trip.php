<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $hidden = ['created_at', 'updated_at'];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_list', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_list', 'id');
    }

    public function VehicleType() 
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type');
    }

    public function TripRoute() 
    {
        return $this->belongsTo(TripRoute::class, 'trip_route', 'id');
    }

    public function Schedule() 
    {
        return $this->belongsTo(Schedule::class, 'schedule');
    }

}
