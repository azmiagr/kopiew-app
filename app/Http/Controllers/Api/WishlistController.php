<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use ResponseHelper;

class WishlistController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'user_id'  => 'required|exists:users,id',
                'place_id' => 'required|exists:places,id',
            ]);

            $wishlist = Wishlist::create($validated);

            return ResponseHelper::success($wishlist, 'Wishlist berhasil dibuat', 201);
        } catch (\Throwable $e) {
            return ResponseHelper::error('Gagal membuat wishlist', 500, $e->getMessage());
        }
    }

    public function index()
    {
        try {
            $wishlists = Wishlist::with(['user', 'place'])->latest()->get();
            return ResponseHelper::success($wishlists, 'Daftar semua wishlist');
        } catch (\Throwable $e) {
            return ResponseHelper::error('Gagal mengambil data wishlist', 500, $e->getMessage());
        }
    }

    public function show(Wishlist $wishlist)
    {
        try {
            $wishlist->load(['user', 'place']);
            return ResponseHelper::success($wishlist, 'Detail wishlist');
        } catch (\Throwable $e) {
            return ResponseHelper::error('Gagal mengambil detail wishlist', 500, $e->getMessage());
        }
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        try {
            $validated = $request->validate([
                'name'     => 'sometimes|required|string|max:255',
                'user_id'  => 'sometimes|required|exists:users,id',
                'place_id' => 'sometimes|required|exists:places,id',
            ]);

            $wishlist->update($validated);

            return ResponseHelper::success($wishlist, 'Wishlist berhasil diperbarui');
        } catch (\Throwable $e) {
            return ResponseHelper::error('Gagal memperbarui wishlist', 500, $e->getMessage());
        }
    }

    public function destroy(Wishlist $wishlist)
    {
        try {
            $wishlist->delete();
            return ResponseHelper::success(null, 'Wishlist berhasil dihapus');
        } catch (\Throwable $e) {
            return ResponseHelper::error('Gagal menghapus wishlist', 500, $e->getMessage());
        }
    }
}