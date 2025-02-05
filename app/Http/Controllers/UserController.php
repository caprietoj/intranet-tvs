<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name')->toArray();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'cargo'    => 'required|string|max:255',  // Validación para cargo
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|string'
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'cargo'    => $data['cargo'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles([$data['role']]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $userRoles = $user->getRoleNames()->toArray();
        $roles = Role::pluck('name')->toArray();
        return view('admin.users.edit', compact('user', 'userRoles', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'cargo'    => 'required|string|max:255',  // Validación para cargo
            'email'    => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => 'required|string'
        ]);

        $user = User::findOrFail($id);
        $user->name  = $data['name'];
        $user->cargo = $data['cargo'];
        $user->email = $data['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles([$data['role']]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }
}