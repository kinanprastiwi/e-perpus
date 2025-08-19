<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:users,nis',
            'fullname' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'kelas' => 'required',
            'alamat' => 'required',
        ]);

        $lastUser = User::where('role', 'anggota')->orderBy('id_user', 'desc')->first();
        $nextId = $lastUser ? (int) substr($lastUser->kode_user, 2) + 1 : 1;
        $kode_user = 'AG' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        User::create([
            'kode_user' => $kode_user,
            'nis' => $request->nis,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'role' => 'anggota',
            'join_date' => now(),
        ]);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);
        
        $request->validate([
            'nis' => 'required|unique:users,nis,' . $id . ',id_user',
            'fullname' => 'required',
            'username' => 'required|unique:users,username,' . $id . ',id_user',
            'kelas' => 'required',
            'alamat' => 'required',
        ]);

        $anggota->update($request->only(['nis', 'fullname', 'username', 'kelas', 'alamat', 'verif']));

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = User::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}