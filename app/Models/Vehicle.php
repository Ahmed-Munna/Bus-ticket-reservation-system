<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_name',
        'vehicle_type_id',
        'registration_number',
        'chasis_number',
        'engine_number',
        'model',
        'owner_name',
        'owner_phone',
        'brand_name',
        'status',
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function Trips()
    {
        return $this->hasOne(Trip::class, 'vehicle_id');
    }
}
