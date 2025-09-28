<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use ResponseHelper;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(auth()->id());

        return ResponseHelper::success($user, "Success to get user profile", 200);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . auth()->id(),
            'bio' => 'sometimes|string',
        ]);

        $user = User::findOrFail(auth()->id());
        $user->update($validated);

        return ResponseHelper::success($user, "Success to update user profile", 200);
    }
}
