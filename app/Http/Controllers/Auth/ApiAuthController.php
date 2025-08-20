<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
   public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string', // Ubah dari 'email' menjadi 'username'
        'password' => 'required|string',
    ]);

    // Cari user berdasarkan username BUKAN email
    $user = User::where('username', $request->username)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Username atau password salah.'
        ], 401);
    }

    // Cek jika user sudah terverifikasi
    if ($user->verif !== 'Terverifikasi') {
        return response()->json([
            'message' => 'Akun belum terverifikasi. Silakan hubungi administrator.'
        ], 403);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login berhasil',
        'user' => $user,
        'token' => $token
    ]);
}

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }
}