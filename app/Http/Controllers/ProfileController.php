<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        // Return the profile edit view; using settings view as an example
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = $request->user();
        $user->name  = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('admin.settings')->with('success', 'Perfil actualizado correctamente');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        // ...existing deletion logic...
        $user->delete();
        return redirect('/');
    }
}
