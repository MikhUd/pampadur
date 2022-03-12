<?php

namespace App\Services;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Models\DatingCard;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Services\Interfaces\DatingCardServiceContract;
use App\Services\Interfaces\TagSynchronizerContract;
use Illuminate\Support\Arr;

class DatingCardService implements DatingCardServiceContract
{
    private $datingCardRepository;
    private $tagSynchronizer;

    public function __construct(DatingCardRepositoryContract $datingCardRepository,TagSynchronizerContract $tagSynchronizer)
    {
        $this->datingCardRepository = $datingCardRepository;
        $this->tagSynchronizer = $tagSynchronizer;
    }

    /**
     * @return DatingCard
     */
    public function store(CreateDatingCardRequest $request): ?DatingCard
    {
        if ($request->user()->datingCard()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'User can only have one dating card'
            ], 204);
        }

        $requestFields = $request->toArray();
        
        $datingCard = $this->datingCardRepository->create(
            Arr::except($requestFields, [
                'tags',
                'images',
            ])
        );

        $this->tagSynchronizer->sync(
            collect($requestFields['tags']),
            $datingCard
        );

        return null;
    }

}
