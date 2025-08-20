<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - E-Perpus LSP</title>
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
        }
        
        .header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .user-info {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
        
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 30px;
            border-radius: 8px;
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
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="text-center mb-4">
                    <h4>Perpustakaan LTE CS</h4>
                    <div class="online-indicator">
                        <span class="badge bg-success">Online</span>
                    </div>
                </div>
                
                <div class="user-info-sidebar text-center mb-4">
                    <img src="https://ui-avatars.com/api/?name=NJuroimani&background=random" alt="User" class="rounded-circle mb-2" width="80">
                    <h6>NJuroimani</h6>
                    <p class="small">Anggota Perpustakaan</p>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link active" href="#"><i class="fas fa-home"></i> Dashboard</a>
                    <a class="nav-link" href="#"><i class="fas fa-book"></i> Peminjaman Buku</a>
                    <a class="nav-link" href="#"><i class="fas fa-history"></i> Riwayat Peminjaman</a>
                    <a class="nav-link" href="#"><i class="fas fa-book-open"></i> Koleksi Buku</a>
                    <a class="nav-link" href="#"><i class="fas fa-user"></i> Profil Saya</a>
                    <a class="nav-link" href="#"><i class="fas fa-cog"></i> Pengaturan</a>
                    <a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="header d-flex justify-content-between align-items-center">
                    <h4>Dashboard</h4>
                    <div>
                        <span class="me-3">Selasa, 20 November 2022</span>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
                
                <div class="welcome-banner">
                    <h3>Selamat Datang, NJuroimani di E-Perpus LSP</h3>
                    <p>Selamat membaca dan jelajahi koleksi buku kami yang lengkap</p>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card-stat card text-center p-4">
                            <div class="card-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h3>5</h3>
                            <p class="text-muted">Buku Dipinjam</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card-stat card text-center p-4">
                            <div class="card-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3>2</h3>
                            <p class="text-muted">Peminjaman Aktif</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card-stat card text-center p-4">
                            <div class="card-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <h3>12</h3>
                            <p class="text-muted">Riwayat Peminjaman</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card-stat card text-center p-4">
                            <div class="card-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h3>8</h3>
                            <p class="text-muted">Buku Favorit</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">Peminjaman Aktif</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Judul Buku</th>
                                                <th>Tanggal Pinjam</th>
                                                <th>Jatuh Tempo</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Pemrograman Web Modern</td>
                                                <td>15 Nov 2022</td>
                                                <td>22 Nov 2022</td>
                                                <td><span class="badge bg-warning">Aktif</span></td>
                                            </tr>
                                            <tr>
                                                <td>Desain UI/UX untuk Pemula</td>
                                                <td>18 Nov 2022</td>
                                                <td>25 Nov 2022</td>
                                                <td><span class="badge bg-warning">Aktif</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">Notifikasi</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-bell text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Pengingat Pengembalian</h6>
                                        <p class="small mb-0">Buku "Pemrograman Web Modern" akan jatuh tempo dalam 2 hari</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-info"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Buku Baru</h6>
                                        <p class="small mb-0">Tersedia buku baru tentang Data Science</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Peminjaman Disetujui</h6>
                                        <p class="small mb-0">Peminjaman "Android Development" telah disetujui</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="footer">
                    <p class="mb-0">Alamat: JL. SREAN & Canning, Khandjost Email = perpuslsp@gmail.com | Nomor Telepon: 021909173</p>
                    <p class="mb-0">© 2022 E-Perpus LSP. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>