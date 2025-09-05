<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
 

public function editProfile($id)
{
    $admin = Admin::findOrFail($id);
    return view('admin.profile', compact('admin'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email,' . $id,
        'phone' => ['required', 'digits:10'],
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $admin = Admin::findOrFail($id);

    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->phone = $request->phone;

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->save();

    return response()->json([
        'status' => 2,
        'message' => 'Profile updated successfully!',
        'surl' => route('admin.profile.edit', ['id' => $admin->id]),
    ]);
}


}
