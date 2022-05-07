<?php

namespace App\Http\Controllers\DatingCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Http\Requests\DatingCard\UpdateDatingCardRequest;
use App\Http\Resources\DatingCard\IndexDatingCardResource;
use App\Services\Interfaces\DatingCardServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DatingCardController extends Controller
{

    public function __construct(
        private DatingCardServiceContract $datingCardService
    ) {}

    public function store(CreateDatingCardRequest $request): JsonResponse
    {
        return $this->datingCardService->store($request);
    }

    public function update(UpdateDatingCardRequest $request): JsonResponse
    {
        return $this->datingCardService->update($request);
    }

    public function index(Request $request): JsonResponse
    {
        $datingCard = $request->user()->datingCard;

        return response()->json([
            'status' => (bool)$datingCard,
            'datingCard' => new IndexDatingCardResource($datingCard),
        ], 200);
    }

    public function getReciprocalLikes(Request $request): JsonResponse
    {
        return response()->json([
            'status' => true,
            'datingCards' => $this->datingCardService->getCardsWithReciprocalLikes($request)->toArray(),
        ]);
    }

    public function getDatingCardsToAssess(Request $request): JsonResponse
    {
        return response()->json([
            'status' => true,
            'datingCards' => $this->datingCardService->getCardsToAssess($request),
        ]);
    }
}
