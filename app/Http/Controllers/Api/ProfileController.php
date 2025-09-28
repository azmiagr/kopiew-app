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
        $user = User::findOrFail(auth('api')->id());

        return ResponseHelper::success($user, "Success to get user profile", 200);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . auth('api')->id(),
            'bio' => 'sometimes|string',
        ]);

        $user = User::findOrFail(auth('api')->id());
        $user->update($validated);

        return ResponseHelper::success($user, "Success to update user profile", 200);
    }

    public function photoUpload(Request $request)
    {
        $validate = $request->validate([
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('photos', $filename, 'public');
        }

        $user = User::findOrFail(auth('api')->id());
        $user->update(['profile_photo' => $filePath]);

        return ResponseHelper::success($user, "Success to upload user profile photo", 201);
    }
}
