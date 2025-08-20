<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
        }
        .register-header {
            background: #2c3e50;
            color: white;
            padding: 25px 20px;
            text-align: center;
        }
        .register-header h2 {
            margin: 0;
            font-weight: 600;
        }
        .register-header p {
            margin: 5px 0 0;
            opacity: 0.8;
        }
        .register-body {
            padding: 25px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-register {
            background: #28a745;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .btn-login {
            background: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h2><i class="fas fa-user-plus"></i> Daftar E-Perpus</h2>
            <p>Buat akun anggota perpustakaan</p>
        </div>
        
        <div class="register-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" 
                               value="{{ old('nis') }}" placeholder="Nomor Induk Siswa" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" 
                               value="{{ old('kelas') }}" placeholder="Contoh: XII IPA 1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="fullname" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" 
                           value="{{ old('fullname') }}" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="{{ old('username') }}" placeholder="Buat username" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email') }}" placeholder="email@contoh.com" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Minimal 6 karakter" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" 
                               name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" 
                              placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                </div>

                <button type="submit" class="btn btn-register w-100 mb-3">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>

                <a href="{{ route('login') }}" class="btn btn-login w-100">
                    <i class="fas fa-sign-in-alt"></i> Kembali ke Login
                </a>
            </form>

            <div class="footer-text">
                <p>© 2024 E-Perpus. All rights reserved.</p>
                <p>Need help? <a href="mailto:support@eperpus.com" style="color: #667eea; text-decoration: none;">
                    support@eperpus.com
                </a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Focus pada input pertama
            document.getElementById('nis').focus();
            
            // Toggle password visibility
            function setupPasswordToggle(inputId) {
                const passwordInput = document.getElementById(inputId);
                const inputGroup = passwordInput.parentElement;
                
                const togglePassword = document.createElement('span');
                togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
                togglePassword.style.cursor = 'pointer';
                togglePassword.style.position = 'absolute';
                togglePassword.style.right = '10px';
                togglePassword.style.top = '50%';
                togglePassword.style.transform = 'translateY(-50%)';
                togglePassword.style.zIndex = '5';
                
                inputGroup.style.position = 'relative';
                
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                });
                
                inputGroup.appendChild(togglePassword);
            }
            
            setupPasswordToggle('password');
            setupPasswordToggle('password_confirmation');
        });
    </script>
</body>
</html>