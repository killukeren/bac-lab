<?php

namespace App\Http\Controllers;

use App\Models\groupModel;
use App\Models\messageModel;
use Illuminate\Http\Request;

class messageController extends Controller
{
    public function index($groupid)
    {
        $group = groupModel::findOrFail($groupid);

        $message = messageModel::where('groupchat_id', $groupid)->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Messages retrieved successfully',
            'data' => $message
        ]);
    }

    public function store(Request $request, $groupid)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $group = groupModel::findOrFail($groupid);

        $message = messageModel::create([
            'message' => $request->message,
            'groupchat_id' => $groupid,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully',
            'data' => $message
        ], 201);
    }
}
