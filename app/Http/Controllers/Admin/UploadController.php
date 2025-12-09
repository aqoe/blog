<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $path = $request->file('image')->store('posts', 'public');

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => asset('storage/' . $path),
            ]
        ]);
    }
}