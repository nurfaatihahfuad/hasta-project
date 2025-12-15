<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Customer Dashboard
    public function index()
    {
        $user = Auth::user();
        $bookings = $user->bookings()->with('vehicle')->latest()->take(5)->get();
        
        return view('dashboard.index', compact('user', 'bookings'));
    }
    
    // Show available vehicles
    public function vehicles()
    {
        $vehicles = Vehicle::where('available', true)->paginate(12);
        return view('dashboard.vehicles', compact('vehicles'));
    }
    
    // Show single vehicle
    public function showVehicle($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('dashboard.vehicle-show', compact('vehicle'));
    }
    
    // Show booking form
    public function bookVehicle($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('dashboard.booking-create', compact('vehicle'));
    }
    
    // Store booking
    public function storeBooking(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        $validated = $request->validate([
            'pickup_date' => 'required|date|after:today',
            'return_date' => 'required|date|after:pickup_date',
            'notes' => 'nullable|max:500',
        ]);
        
        // Check availability
        if (!$vehicle->isAvailable($validated['pickup_date'], $validated['return_date'])) {
            return back()->withErrors(['pickup_date' => 'Vehicle not available for selected dates.']);
        }
        
        // Calculate total price
        $days = \Carbon\Carbon::parse($validated['pickup_date'])
            ->diffInDays(\Carbon\Carbon::parse($validated['return_date'])) + 1;
        $totalPrice = $days * $vehicle->price_per_day;
        
        // Create booking
        $booking = Booking::create([
            'userID' => Auth::id(),
            'vehicleID' => $id,
            'pickup_date' => $validated['pickup_date'],
            'return_date' => $validated['return_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);
        
        return redirect()->route('dashboard.bookings')
            ->with('success', 'Booking created successfully! Booking ID: #' . $booking->bookingID);
    }
    
    // Show user's bookings
    public function bookings()
    {
        $bookings = Auth::user()->bookings()->with('vehicle')->latest()->paginate(10);
        return view('dashboard.bookings', compact('bookings'));
    }
    
    // Cancel booking
    public function cancelBooking($id)
    {
        $booking = Booking::where('userID', Auth::id())->findOrFail($id);
        
        if ($booking->status === 'pending') {
            $booking->status = 'cancelled';
            $booking->save();
            
            return back()->with('success', 'Booking cancelled successfully.');
        }
        
        return back()->withErrors(['error' => 'Cannot cancel booking in current status.']);
    }
    
    // User profile
    public function profile()
    {
        return view('dashboard.profile', ['user' => Auth::user()]);
    }
    
    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:user,email,' . $user->userID . ',userID',
        ]);
        
        $user->update($validated);
        
        return back()->with('success', 'Profile updated successfully.');
    }
}