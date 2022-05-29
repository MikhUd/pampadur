<?php

namespace App\Services;

use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Http\Requests\DatingCard\UpdateDatingCardRequest;
use App\Http\Requests\Meeting\ShowDatingCardsRequest;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Repositories\Interfaces\LikeRepositoryContract;
use App\Services\Interfaces\DatingCardServiceContract;
use App\Services\Interfaces\ImageServiceContract;
use App\Services\Interfaces\TagSynchronizerContract;
use App\Services\Interfaces\UserServiceContract;
use App\Traits\Cache\CacheKeys;
use App\Transformers\DatingCard\DatingCardTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatingCardService implements DatingCardServiceContract
{
    use CacheKeys;

    public function __construct(
        private DatingCardRepositoryContract $datingCardRepository,
        private TagSynchronizerContract $tagSynchronizer,
        private ImageServiceContract $imageService,
        private UserServiceContract $userService,
        private LikeRepositoryContract $likeRepository,
    ){}

    /**
     * Сохранение анкеты.
     *
     * @param CreateDatingCardRequest $request
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

            $this->imageService->sync(
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
            'datingCard' => $datingCard,
            'message' => 'Dating card successfully created',
        ], 201);
    }

    /**
     * Обновление анкеты.
     *
     * @param UpdateDatingCardRequest $request
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

        DB::beginTransaction();
        try {
            $requestFields = $request->toArray();
            $requestFields['tags'] = collect($requestFields['tags']);
            $datingCard = $this->datingCardRepository->update($datingCard, $requestFields);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Saving dating card failed', ['id' => $user->id]);

            return response()->json([
                'success' => false,
                'message' => "Exception while updating dating card. ID:" . $datingCard->id,
            ], 403);
        }

        return response()->json([
            'success' => true,
            'datingCard' => $datingCard,
            'message' => 'Dating card updated',
        ], 200);
    }

    /**
     * Получение анкет с взаимными лайками.
     *
     * @param Request $request
     * @return Collection
     */
    public function getCardsWithReciprocalLikes(Request $request): JsonResponse
    {
        $reciprocalLikes = $this->likeRepository->getAssessedLikes(auth()->user()->datingCard->id, 1, 1);

        if ($datingCards = $this->datingCardRepository->getDatingCardsByIds($reciprocalLikes->pluck('liker_id')->toArray(), [])) {
            return response()->json([
                'status' => true,
                'count' => $datingCards->count(),
                'datingCards' => $datingCards,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'There are no dating cards',
        ], 400);
    }

    /**
     * Получение 50 анкет для оценок в рандомном порядке.
     *
     * @param ShowDatingCardsRequest $request
     * @return Collection
     */
    public function getCardsToAssess(ShowDatingCardsRequest $request): JsonResponse
    {
        return Cache::tags([$this->getDatingCardsCacheTag(), $this->getDatingCardsToAssessCacheTag(auth()->user()->id)])->rememberForever(
            $this->getDatingCardsToAssessByFiltersCacheKey($request->all(), $email = auth()->user()->email), function () use ($request, $email) {
                Cache::tags([$this->getDatingCardsToAssessCacheTag(auth()->user()->id)])->flush();
                $datingCard = auth()->user()->datingCard;
                $filters = $request->all();
                $filters['coords'] = [$request->user()->latitude, $request->user()->longitude];
                //Условный ограничитель показа анкет, которые лайкнули текущую, без него сразу будут доставаться все анкеты, которые лайкнули.
                $filters['limit'] = 10;

                $cardsToAssess = $this->datingCardRepository->getCardsWithNotAssessedLikesById($datingCard->id, $filters);
                $cardsToAssess->map(fn($card) => $card->liked_me = true);

                $maxCount = Cache::tags([$this->getDatingCardsCacheTag(), $this->getDailyMaxCountDatingCardsToAssessCacheTag($email)])->rememberForever(
                    $this->getDailyMaxCountDatingCardsToAssessCacheKey($email), fn() => 50
                );

                if ($cardsToAssess->count() < $maxCount) {
                    $cardsToAssess = $cardsToAssess->merge($this->datingCardRepository->getRandomCardsThatNotHaveBeenAssessed(
                        $datingCard,
                        $cardsToAssess,
                        $maxCount - $cardsToAssess->count(),
                        $filters
                    ));
                }

                if ($cardsToAssess->isNotEmpty()) {
                    return response()->json([
                        'status' => true,
                        'count' => $cardsToAssess->count(),
                        'datingCards' => DatingCardTransformer::toArray($cardsToAssess->shuffle()),
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'There are no dating cards',
                ], 400);
            })
        ;
    }
}
