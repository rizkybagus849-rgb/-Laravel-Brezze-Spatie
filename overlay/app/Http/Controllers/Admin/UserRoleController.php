<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->get();
        $roles = Role::orderBy('name')->pluck('name');
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::exists('roles', 'name')],
        ]);

        // Cegah admin mencabut role Admin miliknya sendiri
        if ($user->is($request->user()) && $data['role'] !== 'Admin') {
            return back()->withErrors(['role' => 'Anda tidak dapat mengubah role Admin milik sendiri.']);
        }

        $user->syncRoles($data['role']);
        return back()->with('success', "Role {$user->name} diubah menjadi {$data['role']}.");
    }
}
