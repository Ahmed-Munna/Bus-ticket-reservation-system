<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRoute extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    
    public function ticketPrice() 
    {
        return $this->belongsTo(TicketPrice::class, 'trip_route_id', 'id');
    }

    public function trips() 
    {
        return $this->hasMany(Trip::class, 'trip_route_id', 'id');
    }
}
