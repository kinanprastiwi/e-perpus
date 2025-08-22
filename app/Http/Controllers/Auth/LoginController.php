<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Debug: Log input values
        Log::info('Login attempt:', [
            'username' => $request->username,
            'password' => $request->password,
            'remember' => $request->remember
        ]);

        // Coba login dengan username
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            Log::info('Login success with username: ' . $request->username);
            return $this->authenticated($request);
        }

        // Coba login dengan email
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password], $request->remember)) {
            Log::info('Login success with email: ' . $request->username);
            return $this->authenticated($request);
        }

        // Debug: Check if user exists
        $userExists = \App\Models\User::where('username', $request->username)
                     ->orWhere('email', $request->username)
                     ->exists();
                     
        Log::info('User exists check: ' . ($userExists ? 'YES' : 'NO'));

        throw ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

    /**
     * Handle successful authentication.
     */
    protected function authenticated(Request $request)
    {
        $request->session()->regenerate();
        
        $user = Auth::user();
        
        // Update last login
        $user->update(['terakhir_login' => now()]);
        
        // DEBUG: Tambahkan log ini
        Log::info('Redirecting user: ' . $user->username . ', Role: ' . $user->role);
        
        if (in_array($user->role, ['admin', 'petugas'])) {
            Log::info('Redirecting to admin dashboard');
            return redirect()->intended('/admin/dashboard');
        } else {
            Log::info('Redirecting to user dashboard');
            return redirect()->intended('/user/dashboard');
        }
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:users,nis',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'kelas' => 'required|string|max:50',
            'alamat' => 'required|string',
        ]);

        try {
            // Create new user
            $user = User::create([
                'nis' => $request->nis,
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'role' => 'anggota',
                'status' => 'active',
            ]);

            // Auto login setelah registrasi
            Auth::login($user);

            return redirect('/user/dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('status', 'Anda telah logout.');
    }
}