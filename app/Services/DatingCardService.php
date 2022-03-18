<?php

namespace App\Services;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Services\Interfaces\DatingCardServiceContract;
use App\Services\Interfaces\ImageServiceContract;
use App\Services\Interfaces\TagSynchronizerContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatingCardService implements DatingCardServiceContract
{
    private $datingCardRepository;
    private $tagSynchronizer;
    private $imageService;

    public function __construct(DatingCardRepositoryContract $datingCardRepository, TagSynchronizerContract $tagSynchronizer, ImageServiceContract $imageService)
    {
        $this->datingCardRepository = $datingCardRepository;
        $this->tagSynchronizer = $tagSynchronizer;
        $this->imageService = $imageService;
    }

    /**
     * Сохранение анкеты
     *
     * @return JsonResponse
     */
    public function store(CreateDatingCardRequest $request): JsonResponse
    {
        $user = auth()->user();
        
        if ($user->datingCard()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'User can only have one dating card',
            ], 400);
        }

        $requestFields = $request->toArray();
        $datingCard = null;
        DB::beginTransaction();

        try {
            $datingCard = $this->datingCardRepository->create(
                Arr::except($requestFields, [
                    'tags',
                    'images',
                ])
            );
            $this->datingCardRepository->bindUser($datingCard, $user);

            $this->tagSynchronizer->sync(
                $datingCard,
                collect($requestFields['tags']),
            );

            $this->imageService->attachImages(
                $datingCard,
                $requestFields['images'],
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Saving dating card failed', ['id' => $user->id]);

            return response()->json([
                'success' => false,
                'message' => "Exception while creating",
            ], 403);
        }

        return response()->json([
            'success' => true,
            'datingCard' => $datingCard->withoutRelations(),
            'message' => 'Dating card successfully created',
        ], 201);
    }

}
