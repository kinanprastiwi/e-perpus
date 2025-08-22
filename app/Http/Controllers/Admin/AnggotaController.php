<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $anggota = User::where('role', 'anggota')
            ->when($search, function($query, $search) {
                return $query->where('fullname', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%")
                           ->orWhere('username', 'like', "%{$search}%");
            })
            ->orderBy('fullname')
            ->paginate(10);

        return view('admin.anggota.index', compact('anggota', 'search'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:users,nis',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'kelas' => 'required|string|max:50',
            'alamat' => 'required|string',
            'verif' => 'required|in:Terverifikasi,Belum Terverifikasi'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'anggota';
        $validated['kode_user'] = 'AGT' . Str::random(3) . time();
        $validated['join_date'] = now();

        User::create($validated);

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    public function show(User $anggota)
    {
        if ($anggota->role !== 'anggota') {
            abort(404);
        }

        return view('admin.anggota.show', compact('anggota'));
    }

    public function edit(User $anggota)
    {
        if ($anggota->role !== 'anggota') {
            abort(404);
        }

        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, User $anggota)
    {
        if ($anggota->role !== 'anggota') {
            abort(404);
        }

        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:users,nis,' . $anggota->id_user . ',id_user',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $anggota->id_user . ',id_user',
            'username' => 'required|string|max:50|unique:users,username,' . $anggota->id_user . ',id_user',
            'password' => 'nullable|string|min:6|confirmed',
            'kelas' => 'required|string|max:50',
            'alamat' => 'required|string',
            'verif' => 'required|in:Terverifikasi,Belum Terverifikasi'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $anggota->update($validated);

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil diperbarui');
    }

    public function destroy(User $anggota)
    {
        if ($anggota->role !== 'anggota') {
            abort(404);
        }

        if ($anggota->peminjaman()->where('status', 'Dipinjam')->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus anggota karena masih memiliki pinjaman aktif');
        }

        $anggota->delete();

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil dihapus');
    }

    public function toggleStatus(User $anggota)
    {
        if ($anggota->role !== 'anggota') {
            abort(404);
        }

        $anggota->update([
            'verif' => $anggota->verif === 'Terverifikasi' ? 'Belum Terverifikasi' : 'Terverifikasi'
        ]);

        return redirect()->back()
            ->with('success', 'Status verifikasi anggota berhasil diubah');
    }

    public function export()
    {
        // Tambahkan fungsi export jika diperlukan
        return response()->streamDownload(function () {
            $anggota = User::where('role', 'anggota')->get();
            echo "NIS,Nama,Email,Kelas,Status\n";
            foreach ($anggota as $a) {
                echo "{$a->nis},{$a->fullname},{$a->email},{$a->kelas},{$a->verif}\n";
            }
        }, 'anggota-perpustakaan-' . date('Y-m-d') . '.csv');
    }
}