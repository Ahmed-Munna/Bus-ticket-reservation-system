<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'journey_date',
    ];

    public function Trips()
    {
        return $this->hasMany(Trip::class);
    }
}
