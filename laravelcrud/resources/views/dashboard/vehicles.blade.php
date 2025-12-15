@extends('dashboard.layout')

@section('title', 'Available Vehicles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-car"></i> Available Vehicles</h2>
    <div>
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search vehicles..." value="{{ request('search') }}">
            <select name="type" class="form-select me-2" style="width: auto;">
                <option value="">All Types</option>
                <option value="Sedan" {{ request('type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                <option value="SUV" {{ request('type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                <option value="Van" {{ request('type') == 'Van' ? 'selected' : '' }}>Van</option>
                <option value="Luxury" {{ request('type') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
</div>

@if($vehicles->count() > 0)
<div class="row">
    @foreach($vehicles as $vehicle)
    <div class="col-md-4 mb-4">
        <div class="card vehicle-card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $vehicle->brand }} {{ $vehicle->model }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $vehicle->year }} • {{ $vehicle->type }}</h6>
                
                <p class="card-text">
                    <i class="fas fa-users"></i> {{ $vehicle->seats }} seats<br>
                    <i class="fas fa-gas-pump"></i> {{ $vehicle->type }}<br>
                    <i class="fas fa-star text-warning"></i> {{ $vehicle->description }}
                </p>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h4 class="text-primary mb-0">${{ number_format($vehicle->price_per_day, 2) }}/day</h4>
                    <a href="{{ route('dashboard.vehicle.show', $vehicle->vehicleID) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0">
                <a href="{{ route('dashboard.vehicle.book', $vehicle->vehicleID) }}" class="btn btn-success w-100">
                    <i class="fas fa-calendar-check"></i> Book Now
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center">
    {{ $vehicles->links() }}
</div>
@else
<div class="text-center py-5">
    <i class="fas fa-car fa-4x text-muted mb-3"></i>
    <h3>No Vehicles Available</h3>
    <p class="text-muted">Check back later for new vehicles.</p>
</div>
@endif
@endsection