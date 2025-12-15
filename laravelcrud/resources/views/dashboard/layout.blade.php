<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Vehicle Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #2c3e50; }
        .sidebar a { color: #ecf0f1; padding: 15px 20px; display: block; text-decoration: none; }
        .sidebar a:hover { background: #34495e; }
        .sidebar a.active { background: #3498db; }
        .dashboard-card { border-radius: 10px; border: none; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .vehicle-card { transition: transform 0.3s; }
        .vehicle-card:hover { transform: translateY(-5px); }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 0.8em; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white"><i class="fas fa-car"></i> VehicleBooking</h4>
                        <p class="text-muted">Welcome, {{ Auth::user()->name }}</p>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li>
                            <a href="{{ route('dashboard.index') }}" class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.vehicles') }}" class="{{ request()->routeIs('dashboard.vehicles') ? 'active' : '' }}">
                                <i class="fas fa-car"></i> Available Vehicles
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.bookings') }}" class="{{ request()->routeIs('dashboard.bookings') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt"></i> My Bookings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.profile') }}" class="{{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                        </li>
                        <li class="mt-4">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-10 ml-sm-auto px-4">
                <!-- Top Navigation -->
                <nav class="navbar navbar-light bg-white border-bottom py-3">
                    <div class="container-fluid">
                        <span class="navbar-brand">
                            <i class="fas fa-bars d-md-none" id="sidebarToggle"></i>
                            @yield('title', 'Dashboard')
                        </span>
                        <div class="d-flex align-items-center">
                            <span class="me-3">{{ Auth::user()->email }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <div class="py-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('d-none');
        });
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    </script>
    @yield('scripts')
</body>
</html>