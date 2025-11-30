<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    function index()
    {
        return view('dashboard');
    }

    function manageUsers()
    {
        $users = User::all();
        return view('admin.manage-users', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,instructor,student',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role berhasil diubah!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth::user()->id === $user->id) {
            return redirect()->back()->withErrors('Anda tidak dapat menghapus akun sendiri');
        }
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
