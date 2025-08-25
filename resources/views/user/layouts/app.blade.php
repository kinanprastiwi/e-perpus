<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Perpus - Anggota')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3a5a78;
            --secondary-color: #e9ecef;
            --accent-color: #5c7ea1;
            --text-dark: #343a40;
            --text-light: #6c757d;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: var(--text-dark);
        }
        
        .sidebar {
            background-color: var(--primary-color);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            width: 250px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 6px 0;
            border-radius: 5px;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        
        .header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .card-stat {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            border: none;
            height: 100%;
        }
        
        .card-stat:hover {
            transform: translateY(-5px);
        }
        
        .card-stat .card-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="text-center mb-4">
                    <h4>E-Perpus</h4>
                    <div class="online-indicator">
                        <span class="badge bg-success">Online</span>
                    </div>
                </div>
                
                <div class="user-info-sidebar text-center mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->fullname }}&background=random" 
                         alt="User" class="rounded-circle mb-2" width="80">
                    <h6>{{ auth()->user()->fullname }}</h6>
                    <p class="small">Anggota Perpustakaan</p>
                    <span class="badge bg-{{ auth()->user()->verif == 'Terverifikasi' ? 'success' : 'warning' }}">
                        {{ auth()->user()->verif }}
                    </span>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link {{ Request::is('user/dashboard') ? 'active' : '' }}" 
                       href="{{ route('user.dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a class="nav-link {{ Request::is('user/peminjaman*') ? 'active' : '' }}" 
                       href="{{ route('user.peminjaman.index') }}">
                        <i class="fas fa-book"></i> Peminjaman
                    </a>
                    <a class="nav-link {{ Request::is('user/buku*') ? 'active' : '' }}" 
                       href="{{ route('user.buku.index') }}">
                        <i class="fas fa-book-open"></i> Koleksi Buku
                    </a>
                    <a class="nav-link {{ Request::is('user/profil*') ? 'active' : '' }}" 
                       href="{{ route('user.profil') }}">
                        <i class="fas fa-user"></i> Profil Saya
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="nav-link">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link p-0 border-0 text-start w-100">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="header d-flex justify-content-between align-items-center">
                    <h4>@yield('page-title', 'Dashboard')</h4>
                    <div>
                        <span class="me-3">{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>