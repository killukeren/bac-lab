<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'User data retrieved successfully',
            'data' => User::all(),
        ]);
    }

    public function profile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function getall($id)
    {
        $user = User::findOrFail($id);
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'All user not found',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'All user retrieved successfully',
            'data' => $user,
        ]);
    }

    public function showall()
    {
        $users = User::all();
        if(!$users){
            return response()->json([
                'status' => false,
                'message' => 'All user not found',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'All user retrieved successfully',
            'data' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:8',
        ]);

        $user->update($request->all());

        return response()->json($user->fresh());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:superadmin,admin,karyawan',
            'password' => 'required|string|min:8',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? 'karyawan',
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|in:superadmin,admin,karyawan',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('role'));

        return response()->json([
            'status' => true,
            'message' => 'User role updated successfully',
            'data' => $user,
        ]);

    }
}

