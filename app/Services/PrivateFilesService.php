<?php

namespace App\Services;



use App\Models\Image;
use App\Services\Interfaces\PrivateFilesServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PrivateFilesService implements PrivateFilesServiceContract
{
    private $options = [
        'path' => 'Path',
        'dating_card' => 'DatingCard',
    ];

    private function getByPath($path): JsonResponse
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

        return $this->getSuccessfullyResponse([base64_encode(file_get_contents(Storage::path($path)))]);
    }

    private function getByDatingCard(): JsonResponse
    {
        $items = [];
        foreach (auth()->user()->datingCard->images as $image) {
            $items[] = base64_encode(file_get_contents(Storage::path($image->path)));
        }

        return $this->getSuccessfullyResponse($items);
    }

    public function getFiles(Request $request): JsonResponse
    {
        foreach ($this->options as $key => $value) {
            if ($request->has($key)) {
                return $this->{'getBy' . $value}($request[$key]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Неверные параметры запроса',
        ]);
    }

    private function getSuccessfullyResponse($items): JsonResponse
    {
        return response()->json([
            'status' => true,
            'items' => $items
        ]);
    }
}
