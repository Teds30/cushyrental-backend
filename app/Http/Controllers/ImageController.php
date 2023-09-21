<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException as ExceptionFileNotFoundException;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Image::all();

        return $res;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path = $request->path ?? 'images';
        if ($request->has('image')) {
            $image = $request->file('image');
            $name = $request->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            // $image->move('images/', $name);
            $filePath = $request->file('image')->storeAs($path, $name, 'uploads');
            // Storage::disk('myDisk')->put('/attribute_icons/' . $name, file_get_contents($image));

            $res = Image::create(['image' => $filePath]);

            return response()->json(['success' => 'Uploaded successfully', 'path' => $path, 'name' => $name, 'image' => $res]);
        }
        return response()->json('Failed to upload.');
    }

    /**
     * Display the specified resource.
     */
    public function showImage($fileName)
    {
        $pathToFile = storage_path("app/uploads/images/" . $fileName);
        try {
            return response()->file($pathToFile);
        } catch (ExceptionFileNotFoundException $exception) {
            return response()->json("File not found.", 404);
        }
    }

    public function showChatImage($room_id, $fileName)
    {
        $pathToFile = storage_path("app/uploads/chats/" . $room_id . "/" . $fileName);
        try {
            return response()->file($pathToFile);
        } catch (ExceptionFileNotFoundException $exception) {
            return response()->json("File not found.", 404);
        }
    }

    public function showIcon($fileName)
    {
        $pathToFile = storage_path("app/uploads/attribute_icons/" . $fileName);
        try {
            return response()->file($pathToFile);
        } catch (ExceptionFileNotFoundException $exception) {
            return response()->json("File not found.", 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($fileName)
    {
        // $res = Storage::delete($fileName);
        $res = unlink(storage_path('app/uploads/attribute_icons/' . $fileName));

        return response()->json($res);
    }
}
