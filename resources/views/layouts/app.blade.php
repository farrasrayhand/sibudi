<!DOCTYPE html>
<html lang="id">
<head>
    @php($appName = 'Sistem Informasi Buku Tamu Digital - Sibudi')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ $appName }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #2c3e50;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            align-items: center;
            display: flex;
            gap: 10px;
            font-weight: bold;
            font-size: 1.05rem;
            line-height: 1.2;
            max-width: min(720px, 78vw);
            white-space: normal;
        }
        .app-logo {
            background-color: white;
            border-radius: 6px;
            height: 42px;
            object-fit: contain;
            padding: 3px;
            width: 42px;
        }
        .sidebar {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: fit-content;
        }
        .main-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-custom {
            border-radius: 5px;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .badge-status {
            padding: 8px 12px;
            border-radius: 20px;
        }
    </style>
    @yield('extra_css')
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ session('admin_logged_in') ? route('dashboard.index') : route('login') }}">
                <img src="{{ asset('images/logo_disdik.png') }}" alt="Logo Disdik" class="app-logo">
                <span>{{ $appName }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(session('admin_logged_in'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('dashboard.index') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('guestbook.index') }}">
                                <i class="bi bi-table"></i> Data Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-white">
                                <i class="bi bi-person-circle"></i> {{ session('admin_name') }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button class="btn btn-sm btn-outline-light ms-2" type="submit">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> Terjadi kesalahan!
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="container-fluid">
        @yield('content')
    </div>

    <footer class="mt-5 py-4 border-top bg-light">
        <div class="container-fluid text-center text-muted">
            <small>&copy; 2026 {{ $appName }}. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra_js')
</body>
</html>
