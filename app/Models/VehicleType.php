<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'seat_layout',
        'number_of_seats',
        'seat_number',
        'status',
        'has_ac',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'vehicle_type_id', 'id');
    }

    public function ticketPrices()
    {
        return $this->hasOne(TicketPrice::class, 'vehicle_type_id', 'id');
    }
}
