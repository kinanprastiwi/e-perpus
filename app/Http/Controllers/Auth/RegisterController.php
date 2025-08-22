<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

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
            $user = User::create([
                'kode_user' => 'AGT' . Str::random(3) . time(),
                'nis' => $request->nis,
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'role' => 'anggota',
                'verif' => 'Belum Terverifikasi',
                'join_date' => now(),
            ]);

            Auth::login($user);

            return redirect('/user/dashboard')->with('success', 'Registrasi berhasil! Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.')->withInput();
        }
    }
}