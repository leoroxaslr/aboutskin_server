<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProfilePictureController extends Controller
{
    public function upload (Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpeg,jpg'
        ]);

        $image_name = time() . '.' . $request->image->extension();
        $request->image->move(storage_path('app/public/image'), $image_name);

        return response([
            'image' => $image_name 
        ]);
    }
    public function getImage(string $filename) {
        $file = storage_path('app/public/image/' . $filename);

        if (file_exists($file)) {
            $image = file_get_contents($file);
            return response($image, 200)->header('Content-Type', 'image/jpg');
        }
        return response([
            'message' => 'Image not found'
        ], 404);
    }


}
