@extends('dashboard.layout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card dashboard-card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-tachometer-alt"></i> Dashboard Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-car fa-3x text-primary mb-3"></i>
                                <h3>{{ Auth::user()->bookings()->count() }}</h3>
                                <p class="text-muted">Total Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                                <h3>{{ Auth::user()->bookings()->where('status', 'pending')->count() }}</h3>
                                <p class="text-muted">Pending Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <h3>{{ Auth::user()->bookings()->where('status', 'confirmed')->count() }}</h3>
                                <p class="text-muted">Confirmed Bookings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history"></i> Recent Bookings</h5>
            </div>
            <div class="card-body">
                @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Vehicle</th>
                                    <th>Dates</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>#{{ $booking->bookingID }}</td>
                                    <td>{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</td>
                                    <td>{{ $booking->pickup_date->format('M d') }} - {{ $booking->return_date->format('M d, Y') }}</td>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="status-badge status-pending">Pending</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="status-badge status-confirmed">Confirmed</span>
                                        @else
                                            <span class="status-badge status-cancelled">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.bookings') }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h4>No Bookings Yet</h4>
                        <p class="text-muted">You haven't made any bookings yet.</p>
                        <a href="{{ route('dashboard.vehicles') }}" class="btn btn-primary">Browse Vehicles</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard.vehicles') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-car"></i> Book a Vehicle
                    </a>
                    <a href="{{ route('dashboard.bookings') }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-history"></i> View All Bookings
                    </a>
                    <a href="{{ route('dashboard.profile') }}" class="btn btn-info btn-lg">
                        <i class="fas fa-user"></i> Update Profile
                    </a>
                </div>
                
                <hr>
                
                <h6><i class="fas fa-info-circle"></i> Need Help?</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-phone text-primary"></i> Call: 1-800-VEHICLE</li>
                    <li><i class="fas fa-envelope text-primary"></i> Email: support@vehiclebooking.com</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection