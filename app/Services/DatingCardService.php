<?php

namespace App\Services;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Services\Interfaces\DatingCardServiceContract;
use App\Services\Interfaces\ImageServiceContract;
use App\Services\Interfaces\TagSynchronizerContract;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatingCardService implements DatingCardServiceContract
{
    const ATTRIBUTES = [
        'SIMPLY_CHANGEABLE' => [
            'name',
            'about',
            'gender',
            'seeking_for',
            'birth_date',
        ],
        'LOGIC_IN_SERVICE' => [
            'tags' => [
                'service' => 'tagSynchronizer',
                'method' => 'update',
            ],
            'images' => [
                'service' => 'imageService',
                'method' => 'update',
            ]
        ]
    ];

    public function __construct(
        private DatingCardRepositoryContract $datingCardRepository,
        private TagSynchronizerContract $tagSynchronizer,
        private ImageServiceContract $imageService,
        private UserServiceContract $userService,
    ){}

    /**
     * Сохранение анкеты.
     *
     * @return JsonResponse
     */
    public function store(CreateDatingCardRequest $request): JsonResponse
    {
        $user = auth()->user();

        if ($user->datingCard()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'User can have only one dating card',
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

            $this->userService->update(
                $user,
                [
                    'latitude' => $requestFields['coords'][0],
                    'longitude' => $requestFields['coords'][1],
                    'birth_date' => $requestFields['birth_date'],
                ],
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

    /**
     * Обновление анкеты.
     *
     * @return JsonResponse
     */
    public function update(UpdateDatingCardRequest $request): JsonResponse
    {
        $user = auth()->user();
        $datingCard = $user->datingCard;

        if (!$datingCard) {
            return response()->json([
                'success' => false,
                'message' => 'Dating card does not exists',
            ], 400);
        }

        foreach (self::ATTRIBUTES['SIMPLY_CHANGEABLE'] as $attr) {
            if ($request->has($attr)) {
                $datingCard->{$attr} = $request[$attr];
            }
        }

        foreach (self::ATTRIBUTES['LOGIC_IN_SERVICE'] as $attr => $logic) {
            if ($request->has($attr)) {
                $this->{$logic['service']}->{$logic['method']}($datingCard, $request[$attr]);
            }
        }

        $datingCard->save();
        return response()->json([
            'success' => true,
            'message' => 'Dating card updated',
        ], 200);
    }
}
