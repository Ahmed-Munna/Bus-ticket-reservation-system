<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $fillable = [
        'counter_manager_id',
        'name',
        'city',
        'phone',
        'address',
        'status'
    ];

    public function counterManager()
    {
        return $this->belongsTo(User::class, 'counter_manager_id');
    }
}
