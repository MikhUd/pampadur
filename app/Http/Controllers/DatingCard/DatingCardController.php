<?php

namespace App\Http\Controllers\DatingCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DatingCard\CreateDatingCardRequest;
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

    public function update($request)
    {

    }

    public function index(Request $request): JsonResponse
    {
        $datingCard = auth()->user()->datingCard;
        return response()->json([
            'status' => (bool)$datingCard,
            'datingCard' => $datingCard,
        ], 200);
    }
}
