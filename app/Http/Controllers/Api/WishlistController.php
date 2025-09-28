<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'user_id'  => 'required|exists:users,id',
            'place_id' => 'required|exists:places,id',
        ]);

        $wishlist = Wishlist::create($validated);

        return response()->json([
            'message' => 'Wishlist berhasil dibuat',
            'data'    => $wishlist
        ], 201);
    }

    public function index()
    {
        $wishlists = Wishlist::with(['user', 'place'])->latest()->get();

        return response()->json([
            'message' => 'Daftar semua wishlist',
            'data'    => $wishlists
        ]);
    }

    public function show(Wishlist $wishlist)
    {
        $wishlist->load(['user', 'place']);

        return response()->json([
            'message' => 'Detail wishlist',
            'data'    => $wishlist
        ]);
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        $validated = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'user_id'  => 'sometimes|required|exists:users,id',
            'place_id' => 'sometimes|required|exists:places,id',
        ]);

        $wishlist->update($validated);

        return response()->json([
            'message' => 'Wishlist berhasil diperbarui',
            'data'    => $wishlist
        ]);
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();

        return response()->json([
            'message' => 'Wishlist berhasil dihapus'
        ]);
    }
}