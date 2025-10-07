<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua grup beserta anggotanya.
     */
    public function index()
    {
        $groups = Group::with('users')->get();
    $users = User::all(); // ← penting agar modal bisa menampilkan semua user

    return view('admin.groupmanagement', compact('groups', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan grup baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255|unique:groups,name',
            'users'   => 'array|nullable',
            'users.*' => 'exists:users,id',
        ]);

        // Buat grup baru
        $group = Group::create([
            'name' => $request->name,
        ]);

        // Tambahkan user ke grup
        if ($request->has('users')) {
            User::whereIn('id', $request->users)
                ->update(['group_id' => $group->id]);
        }

        return redirect()->route('groups.index')->with('success', 'Kelompok berhasil ditambahkan.');
    }

    /**
     * Menampilkan data grup dan user dalam bentuk JSON untuk modal edit.
     * Digunakan oleh AJAX saat klik tombol edit.
     */
    public function edit(Group $group)
    {
        $group->load('users');
    $users = User::all();


        // Jika permintaan dari AJAX, kirim JSON
        if (request()->ajax()) {
            return response()->json([
                'group' => $group,
                'users' => $users,
            ]);
        }

        // Jika bukan AJAX (fallback)
        return view('admin.groupmanagement', compact('group', 'users'));
    }

    /**
     * Update data grup dan anggota.
     */
    public function update(Request $request, Group $group)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'users'   => 'array|nullable',
        'users.*' => 'exists:users,id',
    ]);

    // Update nama grup
    $group->update(['name' => $request->name]);

    // Lepas semua user lama dari grup ini
    User::where('group_id', $group->id)->update(['group_id' => null]);

    // Masukkan user baru
    if ($request->has('users')) {
        User::whereIn('id', $request->users)->update(['group_id' => $group->id]);
    }

    return redirect()->route('groups.index')->with('success', 'Kelompok berhasil diperbarui.');
}

    /**
     * Hapus grup dan lepaskan anggotanya.
     */
    public function destroy(Group $group)
    {
        // Lepas semua user dari grup
        User::where('group_id', $group->id)->update(['group_id' => null]);

        // Hapus grup
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Kelompok berhasil dihapus.');
    }
}
