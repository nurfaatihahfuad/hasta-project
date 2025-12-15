<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'bookingID';
    protected $fillable = [
        'userID', 'vehicleID', 'pickup_date', 'return_date',
        'total_price', 'status', 'notes'
    ];
    
    protected $casts = [
        'pickup_date' => 'date',
        'return_date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicleID');
    }
    
    public function calculateTotalPrice()
    {
        $days = $this->pickup_date->diffInDays($this->return_date) + 1;
        return $days * $this->vehicle->price_per_day;
    }
}