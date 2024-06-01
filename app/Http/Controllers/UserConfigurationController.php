<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserConfigurationController extends Controller
{
    // Tampilkan halaman untuk mengubah peran pengguna
    public function index()
    {
        $users = User::all();
        return view('user_configuration.index', compact('users'));
    }

    // Tampilkan halaman edit peran pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user_configuration.edit', compact('user'));
    }

    // Perbarui peran pengguna
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:superadmin,admin,user',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('user_configuration.index')->with('success', 'User role updated successfully.');
    }
}
