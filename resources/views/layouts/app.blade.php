<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sistem Posyandu' }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);
            min-height: 100vh;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 12px;
        }
        .btn {
            border-radius: 8px;
        }
        .form-control, .form-select {
            border-radius: 8px;
        }
        .navbar {
            background: linear-gradient(135deg, #1976d2 0%, #388e3c 100%) !important;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        .badge {
            font-size: 0.75em;
        }
        .alert {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('posyandu.index') }}">
                <i class="bi bi-heart-pulse me-2"></i>
                Sistem Posyandu
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posyandu.index') ? 'active' : '' }}" 
                           href="{{ route('posyandu.index') }}">
                            <i class="bi bi-plus-circle me-1"></i>
                            Input Data
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posyandu.riwayat') ? 'active' : '' }}" 
                           href="{{ route('posyandu.riwayat') }}">
                            <i class="bi bi-table me-1"></i>
                            Riwayat Data
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4 text-center text-muted">
        <div class="container">
            <p class="mb-0">
                <i class="bi bi-heart-fill text-danger me-1"></i>
                Sistem Posyandu &copy; {{ date('Y') }} - Untuk Kesehatan Masyarakat
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Auto calculate IMT
        function calculateIMT() {
            const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
            const tinggiBadan = parseFloat(document.getElementById('tinggi_badan')?.value || 0);
            
            if (beratBadan > 0 && tinggiBadan > 0) {
                const tinggiMeter = tinggiBadan / 100;
                const imt = (beratBadan / (tinggiMeter * tinggiMeter)).toFixed(1);
                
                const imtField = document.getElementById('imt');
                if (imtField) {
                    imtField.value = imt;
                }
            }
        }

        // Add event listeners for IMT calculation
        document.addEventListener('DOMContentLoaded', function() {
            const beratBadanField = document.getElementById('berat_badan');
            const tinggiBadanField = document.getElementById('tinggi_badan');
            
            if (beratBadanField) beratBadanField.addEventListener('input', calculateIMT);
            if (tinggiBadanField) tinggiBadanField.addEventListener('input', calculateIMT);
        });

        // Confirm delete
        function confirmDelete(nama) {
            return confirm(`Apakah Anda yakin ingin menghapus data ${nama}? Tindakan ini tidak dapat dibatalkan.`);
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
