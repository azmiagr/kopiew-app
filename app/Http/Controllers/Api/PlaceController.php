<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlaceController extends Controller
{

    public function store(Request $request) {
        $validated = $request->validate([
            "name" => 'sometimes|required|string|min:5|max:100',
            "address" => 'sometimes|required|string|max:255',
            "description" => 'sometimes|required|string|max:255'
        ]);

        $place = new Place($validated);
        $place->user_id = auth()->id();
        $place->save();

        return response()->json([
            'message' => 'Place berhasil dibuat',
            'data' => $place
        ]);
    }

    public function index() {
        $places = Place::with('photos','reviews')->latest()->get();

        return response()->json([
            "message" => "Daftar semua places",
            "data" => $places
        ]);

    }

    public function show(Place $place) {
        $place->load('photos', 'reviews');

        return response()->json([
            "message" => "Detail place",
            "data" => $place
        ]);
    }

    public function update(Request $request, Place $place) {

        if($place->user_id !== auth()->id()) {
            return response()->json([
                "message" => "Anda tidak memiliki akses untuk mengubah"
            ], 403);
        }

        $validated = $request->validate([
            "name" => 'sometimes|required|string|min:5|max:100',
            "address" => 'sometimes|required|string|max:255',
            "description" => 'sometimes|required|string|max:255'
        ]);

        $place->update($validated);

        return response()->json([
            "message" => "Place berhasil diubah",
            "data" => $place
        ]);

    }

    public function destroy(Place $place)
{
    if ($place->user_id !== auth()->id()) {
        return response()->json([
            'message' => 'Anda tidak memiliki akses untuk menghapus.'
        ], 403);
    }

    $place->delete();

    return response()->json([
        'message' => 'Place berhasil dihapus'
    ], 200);
}
}
