<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PhotoController extends Controller
{
    public function index($placeID) 
    {
        try {
            $data = Photo::with(["user", "place"])->where('place_id', $placeID)->get();
            if ($data->isEmpty()) {
                return response()->json([
                    "message" => "no photos found",
                    "data" => []
                ], 404);
            }

            return response()->json([
                "messsage" => "list photos",
                "data" => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function store(Request $request, $placeID) 
    {
        try {
            $validate = $request->validate([
                'url' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'caption' => 'required|string|max:255',
            ]);
            

            if ($request->hasFile('url')) {
                $file = $request->file('url');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('photos', $filename, 'public');
            }
            $data = Photo::create([
                "user_id" => auth('api')->user()->id,
                "place_id" => $placeID,
                "url" => '/storage/' . $filePath,
                "caption" => $validate['caption'],
            ]);

            return response()->json([
                "message" => "photo created",
                "data" => $data
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function show($placeID, $id) 
    {
        try {
            $data = Photo::with(["user", "place"])->where('place_id', $placeID)->find($id);
            
            if (!$data) {
                return response()->json([
                    "message" => "photo not found",
                    "data" => null
                ], 404);
            }

            return response()->json([
                "message" => "detail photo",
                "data" => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $placeID, $id) 
    {
        try {
            $request->validate([
                'url' => 'file|mimes:jpg,jpeg,png|max:2048',
                'caption' => 'required|string|max:255',
            ]);
            $data = Photo::where("place_id", $placeID)->find($id);
            if (!$data) {
                return response()->json([
                    "message" => "photo not found",
                    "data" => null
                ], 404);
            }
            if ($data['user_id'] !== auth('api')->user()->id) {
                return response()->json([
                    "message" => "unauthorized",
                    "data" => null
                ], 403);
            }

            if ($request->hasFile('url')) {
                $file = $request->file('url');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('photos', $filename, 'public');

                    if ($data->url && Storage::disk('public')->exists(str_replace('/storage/', '', $data->url))) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $data->url));
                    }
            }

            $data->update([
                'url' => $request->hasFile('url') ? '/storage/' . $filePath : $data->url,
                'caption' => $request->caption
            ]);

            return response()->json([
                "message" => "photo updated",
                "data" => $data
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function destroy($placeID, $id) 
    {
        try {
            $data = Photo::where("place_id", $placeID)->find($id);
            if (!$data) {
                return response()->json([
                    "message" => "photo not found",
                    "data" => null
                ], 404);
            }

            if ($data['user_id'] !== auth('api')->user()->id) {
                return response()->json([
                    "message" => "unauthorized",
                    "data" => null
                ], 403);
            }
            if ($data->url && Storage::disk('public')->exists(str_replace('/storage/', '', $data->url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $data->url));
            }
            $data->delete();

            return response()->json([
                "message" => "photo deleted",
                "data" => null
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
