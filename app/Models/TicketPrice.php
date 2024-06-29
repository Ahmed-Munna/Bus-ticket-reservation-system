<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPrice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vehicleType() 
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function tripRoute()
    {
        return $this->belongsTo(TripRoute::class, 'trip_route_id');
    }
}
