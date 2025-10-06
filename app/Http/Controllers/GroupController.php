<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua group beserta user anggotanya
        $groups = Group::with('users')->get();
        $users = User::whereNull('group_id')->get(); // user yg belum punya kelompok

        return view('admin.groupmanagement', compact('groups', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereNull('group_id')->get();
        return view('admin.groupmanagement', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255|unique:groups,name',
            'users'  => 'array',
            'users.*'=> 'exists:users,id',
        ]);

        // Buat kelompok
        $group = Group::create([
            'name' => $request->name,
        ]);

        // Tambahkan user ke group
        if ($request->has('users')) {
            User::whereIn('id', $request->users)
                ->update(['group_id' => $group->id]);
        }

        return redirect()->route('groups.index')->with('success', 'Kelompok berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $group->load('users'); // ambil user dalam group
        return view('admin.groupmanagement', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $group->load('users');
        $users = User::all(); // semua user, bisa pilih ulang
        return view('admin.groupmanagement', compact('group', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
  // GroupsController.php
public function update(Request $request, Group $group)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'users' => 'array', // optional, bisa kosong
        'users.*' => 'exists:users,id',
    ]);

    // Update nama grup
    $group->update(['name' => $request->name]);

    // Sync users (menambahkan yang baru, menghapus yang tidak dicentang)
    $group->users()->sync($request->users ?? []);

    return redirect()->route('groups.index')->with('success', 'Group updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        // Lepaskan semua user dari group sebelum delete
        User::where('group_id', $group->id)->update(['group_id' => null]);

        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Kelompok berhasil dihapus.');
    }
}
