<?php

namespace App\Http\Controllers;

use App\Models\groupModel;
use Illuminate\Http\Request;
use App\Models\User;
class groupController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $groups = $user->groups()->with('member')->get();

        return response()->json([
            'status' => true,
            'message' => 'Groups retrieved successfully',
            'data' => $groups
        ], 200);
    }

    public function show($id)
    {
        $group = groupModel::with('member')->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Group details retrieved successfully',
            'data' => $group
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'members'     => 'required|array',
            'member.*'   => 'exists:users,id',
        ]);

        $group = groupModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        $group->member()->attach(array_unique([auth()->id(), ...$request->members]));

        return response()->json([
            'status' => true,
            'message' => 'Group created successfully',
            'data' => $group->load('member')
        ], 201);
    }

    public function join($id)
    {
        $group = groupModel::findOrFail($id);

        if ($group->member()->where('user_id', auth()->id())->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Already a member of this group'
            ], 400);
        }

        $group->member()->attach(auth()->id());

        return response()->json([
            'status' => true,
            'message' => 'Joined group successfully',
            'data' => $group->load('member')
        ], 200);
    }

    public function all()
    {
        $groups = groupModel::with('member')->get();

        return response()->json([
            'status' => true,
            'message' => 'All groups retrieved successfully',
            'data' => $groups
        ], 200);
    }

    public function leave(Request $request, $id)
    {
        $group = groupModel::findOrFail($id);

        $group->member()->detach($request->user_id);

        return response()->json([
            'status' => true,
            'message' => 'Left group successfully',
            'data' => $group->load('member')
        ], 200);
    }
}
