<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class StudentCustomer extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'studentcustomer';
    public $timestamps = false;

    protected $fillable = [
        'userID', 'matricNo', 'faculty', 'residentialCollege'
    ];

    // relationship back to User
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    // relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'userID', 'userID');
    }
}