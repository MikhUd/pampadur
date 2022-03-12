<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GetPrivateFilesController extends Controller
{
    public function __invoke(Request $request, $path)
    {
        if (!($image = Image::where('path', $path)->first())) {
            return response()->json([
                'status' => 'false',
                'message' => 'Image not found'
            ]);
        }
        if (!Gate::allows('view-image', $image)) {
            return response()->json([
                'status' => 'false',
                'message' => "You don't have permission"
            ]);
        }
        return response()->file(Storage::path($path));
    }
}
