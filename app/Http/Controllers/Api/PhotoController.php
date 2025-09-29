<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use ResponseHelper;

class PhotoController extends Controller
{
    public function index($placeID)
    {
        try {
            $data = Photo::with(["user", "place"])->where('place_id', $placeID)->get();
            if ($data->isEmpty()) {
                return ResponseHelper::error("no photos found", 404);
            }

            return ResponseHelper::success($data, "list photos", 200);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage(), 500);
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

            return ResponseHelper::success($data, "photo created", 201);
        } catch (ValidationException $e) {
            return ResponseHelper::error($e->getMessage(), 422, $e->errors());
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage(), 500, $th->getTrace());
        }
    }

    public function show($placeID, $id)
    {
        try {
            $data = Photo::with(["user", "place"])->where('place_id', $placeID)->find($id);

            if (!$data) {
                return ResponseHelper::error("photo not found", 404);
            }

            return ResponseHelper::success($data, "detail photo", 200);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage(), 500);
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
                return ResponseHelper::error("photo not found", 404);
            }
            if ($data['user_id'] !== auth('api')->user()->id) {
                return ResponseHelper::error("user tidak valid", 403);
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

            return ResponseHelper::success($data, "photo updated", 200);
        } catch (ValidationException $e) {
            return ResponseHelper::error($e->getMessage(), 422, $e->errors());
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage(), 500, $th->getTrace());
        }
    }

    public function destroy($placeID, $id)
    {
        try {
            $data = Photo::where("place_id", $placeID)->find($id);
            if (!$data) {
                return ResponseHelper::error("photo not found", 404);
            }

            if ($data['user_id'] !== auth('api')->user()->id) {
                return ResponseHelper::error("user tidak valid", 403);
            }
            if ($data->url && Storage::disk('public')->exists(str_replace('/storage/', '', $data->url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $data->url));
            }
            $data->delete();

            return ResponseHelper::success(null, "photo deleted", 200);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage(), 500, $th->getTrace());
        }
    }
}
