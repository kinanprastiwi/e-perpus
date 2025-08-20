<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'petugas'])->get();
        return view('administrator.index', compact('admins'));
    }

    public function create()
    {
        return view('administrator.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,petugas',
        ]);

        $lastAdmin = User::whereIn('role', ['admin', 'petugas'])->orderBy('id_user', 'desc')->first();
        $prefix = $request->role == 'admin' ? 'AD' : 'PT';
        $nextId = $lastAdmin ? (int) substr($lastAdmin->kode_user, 2) + 1 : 1;
        $kode_user = $prefix . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        User::create([
            'kode_user' => $kode_user,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'verif' => 'Terverifikasi',
            'join_date' => now(),
        ]);

        return redirect()->route('administrator.index')->with('success', 'Administrator berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('administrator.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        $request->validate([
            'fullname' => 'required',
            'username' => 'required|unique:users,username,' . $id . ',id_user',
            'role' => 'required|in:admin,petugas',
        ]);

        $admin->update($request->only(['fullname', 'username', 'role']));

        return redirect()->route('administrator.index')->with('success', 'Administrator berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('administrator.index')->with('success', 'Administrator berhasil dihapus.');
    }
}