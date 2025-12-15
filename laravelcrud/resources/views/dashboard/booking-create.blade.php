@extends('dashboard.layout')

@section('title', 'Book Vehicle')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card dashboard-card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-calendar-check"></i> Book {{ $vehicle->brand }} {{ $vehicle->model }}</h4>
            </div>
            <div class="card-body">
                <!-- Vehicle Info -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-car fa-3x text-primary mb-2"></i>
                                <h5>{{ $vehicle->brand }} {{ $vehicle->model }}</h5>
                                <p class="text-muted">{{ $vehicle->year }} • {{ $vehicle->type }}</p>
                                <h4 class="text-success">${{ number_format($vehicle->price_per_day, 2) }}/day</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h5>Specifications:</h5>
                        <ul>
                            <li><strong>Seats:</strong> {{ $vehicle->seats }}</li>
                            <li><strong>Type:</strong> {{ $vehicle->type }}</li>
                            <li><strong>Description:</strong> {{ $vehicle->description }}</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Booking Form -->
                <form method="POST" action="{{ route('dashboard.booking.store', $vehicle->vehicleID) }}">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pickup Date *</label>
                            <input type="date" name="pickup_date" class="form-control" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Return Date *</label>
                            <input type="date" name="return_date" class="form-control" 
                                   min="{{ date('Y-m-d', strtotime('+2 days')) }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Special Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="3" 
                                  placeholder="Any special requirements..."></textarea>
                    </div>
                    
                    <!-- Price Calculator -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5><i class="fas fa-calculator"></i> Price Calculator</h5>
                            <p>Select dates to see estimated price</p>
                            <div id="priceDisplay" class="text-center py-3">
                                <h3 class="text-success">Select dates first</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    const pricePerDay = {{ $vehicle->price_per_day }};
    
    function calculatePrice() {
        const pickup = document.querySelector('input[name="pickup_date"]').value;
        const returnDate = document.querySelector('input[name="return_date"]').value;
        
        if (pickup && returnDate) {
            const pickupDate = new Date(pickup);
            const returnDateObj = new Date(returnDate);
            const diffTime = Math.abs(returnDateObj - pickupDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const totalPrice = diffDays * pricePerDay;
            
            document.getElementById('priceDisplay').innerHTML = `
                <h3 class="text-success">$${totalPrice.toFixed(2)}</h3>
                <p class="text-muted">${diffDays} days × $${pricePerDay.toFixed(2)}/day</p>
            `;
        }
    }
    
    // Add event listeners
    document.querySelector('input[name="pickup_date"]').addEventListener('change', calculatePrice);
    document.querySelector('input[name="return_date"]').addEventListener('change', calculatePrice);
    
    // Initial calculation if dates are pre-filled
    calculatePrice();
</script>
@endsection
@endsection