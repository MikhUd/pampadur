<?php

namespace App\Services;

use App\Models\Image;
use App\Services\Interfaces\PrivateFilesServiceContract;
use App\Traits\Cache\CacheKeys;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PrivateFilesService implements PrivateFilesServiceContract
{
    use CacheKeys;

    private array $options = [
        'path' => 'Path',
        'dating_card' => 'DatingCard',
    ];

    /**
     * Получение изображения по путю
     *
     * @return JsonResponse
     */
    private function getByPath(string $path): JsonResponse
    {
        if (!($image = Image::where('path', $path)->first())) {
            return response()->json([
                'success' => 'false',
                'message' => 'Image not found'
            ]);
        }
        if (!Gate::allows('view-image', $image)) {
            return response()->json([
                'success' => 'false',
                'message' => "You don't have permission"
            ]);
        }

        return $this->getSuccessfullyResponse([base64_encode(file_get_contents(Storage::path($path)))]);
    }

    /**
     * Получение изображений по анкете
     *
     * @return JsonResponse
     */
    private function getByDatingCard(): JsonResponse
    {
        $user = auth()->user();
        $cacheImages = Cache::remember(
            $this->getDatingCardImagesByUserIdCacheKey($user->id), 3600, function() use($user) {
            $items = [];

            foreach ($user->datingCard->images as $image) {
                $items[] = base64_encode(file_get_contents(Storage::path($image->path)));
            }

            return $items;
        });

        return $this->getSuccessfullyResponse($cacheImages);
    }

    /**
     * Получение приватных файлов
     *
     * @return JsonResponse
     */
    public function getFiles(Request $request): JsonResponse
    {
        foreach ($this->options as $key => $value) {
            if ($request->has($key)) {
                return $this->{'getBy' . $value}($request[$key]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Неверные параметры запроса',
        ]);
    }

    /**
     * Получение успешного ответа
     *
     * @return JsonResponse
     */
    private function getSuccessfullyResponse(array $items): JsonResponse
    {
        return response()->json([
            'success' => true,
            'items' => $items
        ]);
    }
}
