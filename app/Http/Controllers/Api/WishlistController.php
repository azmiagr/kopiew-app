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
                'place_id' => 'required|exists:places,id',
            ]);

            $validated['user_id'] = auth()->id();

            $wishlist = Wishlist::create($validated);

            return ResponseHelper::success($wishlist, 'Wishlist berhasil dibuat', 201);
        } catch (\Throwable $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return ResponseHelper::error('Data tidak valid', 422, $e->errors());
            }
            return ResponseHelper::error('Gagal membuat wishlist', 500, $e->getMessage());
        }
    }

    public function index()
    {
        try {
            $wishlists = Wishlist::where('user_id', auth()->id())
                ->with(['user', 'place'])
                ->latest()
                ->get();
                
            return ResponseHelper::success($wishlists, 'Daftar wishlist user yang login');
        } catch (\Throwable $e) {
            return ResponseHelper::error('Gagal mengambil data wishlist', 500, $e->getMessage());
        }
    }

    public function show(Wishlist $wishlist)
    {
        try {
            if ($wishlist->user_id !== auth()->id()) {
                return ResponseHelper::error('Akses ditolak. Wishlist ini bukan milik Anda.', 403);
            }

            $wishlist->load(['user', 'place']);
            return ResponseHelper::success($wishlist, 'Detail wishlist');
        } catch (\Throwable $e) {
            return ResponseHelper::error('Gagal mengambil detail wishlist', 500, $e->getMessage());
        }
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        try {
            if ($wishlist->user_id !== auth()->id()) {
                return ResponseHelper::error('Akses ditolak. Anda tidak dapat memperbarui Wishlist user lain.', 403);
            }

            $validated = $request->validate([
                'name'     => 'sometimes|required|string|max:255',
                'place_id' => 'sometimes|required|exists:places,id',
            ]);

            if (isset($validated['user_id'])) {
                unset($validated['user_id']);
            }
            
            $wishlist->update($validated);

            return ResponseHelper::success($wishlist, 'Wishlist berhasil diperbarui');
        } catch (\Throwable $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return ResponseHelper::error('Data tidak valid', 422, $e->errors());
            }
            return ResponseHelper::error('Gagal memperbarui wishlist', 500, $e->getMessage());
        }
    }

    public function destroy(Wishlist $wishlist)
    {
        try {
            if ($wishlist->user_id !== auth()->id()) {
                return ResponseHelper::error('Akses ditolak. Anda tidak dapat menghapus Wishlist user lain.', 403);
            }
            
            $wishlist->delete();
            return ResponseHelper::success(null, 'Wishlist berhasil dihapus');
        } catch (\Throwable $e) {
            return ResponseHelper::error('Gagal menghapus wishlist', 500, $e->getMessage());
        }
    }
}