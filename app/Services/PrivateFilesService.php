<?php

namespace App\Services;

use App\Models\DatingCard;
use App\Models\Image;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Services\Interfaces\PrivateFilesServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PrivateFilesService implements PrivateFilesServiceContract
{
    private array $options = [
        'path' => 'Path',
        'dating_card' => 'DatingCard',
    ];

    public function __construct(
        private DatingCardRepositoryContract $datingCardRepository
    ){}

    /**
     * Получение изображения по путю.
     *
     * @param string $path
     * @return JsonResponse
     */
    private function getByPath(string $path): JsonResponse
    {
        if (!($image = Image::where('path', $path)->first())) {
            return response()->json([
                'success' => 'false',
                'message' => 'Image not found'
            ], 404);
        }
        if (!Gate::allows('view-image', $image)) {
            return response()->json([
                'success' => 'false',
                'message' => "You don't have permission"
            ], 403);
        }

        return $this->getSuccessfullyResponse([base64_encode(file_get_contents(Storage::path($path)))]);
    }

    /**
     * Получение изображений по анкете.
     *
     * @param string $datingCard
     * @return JsonResponse
     */
    private function getByDatingCard(string $datingCardId = ''): JsonResponse
    {
        $datingCard = $this->datingCardRepository->getDatingCard(['id' => $datingCardId]) ?? auth()->user()->datingCard;

        $items = [];

        foreach ($datingCard->images as $image) {
            $items[] = base64_encode(file_get_contents(Storage::path($image->path)));
        }

        return $this->getSuccessfullyResponse($items);
    }

    /**
     * Получение приватных файлов.
     *
     * @param Request $request
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
        ], 400);
    }

    /**
     * Получение успешного ответа.
     *
     * @return JsonResponse
     */
    private function getSuccessfullyResponse(array $items = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'count' => count($items),
            'items' => $items,
        ], 200);
    }
}
