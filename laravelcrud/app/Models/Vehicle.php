<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'vehicleID';
    protected $fillable = [
        'brand', 'model', 'year', 'type', 'seats', 
        'price_per_day', 'available', 'image_url', 'description'
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vehicleID');
    }
    
    public function isAvailable($pickupDate, $returnDate)
    {
        $conflict = $this->bookings()
            ->where(function($query) use ($pickupDate, $returnDate) {
                $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                      ->orWhereBetween('return_date', [$pickupDate, $returnDate]);
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
            
        return !$conflict && $this->available;
    }
}