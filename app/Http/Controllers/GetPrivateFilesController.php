<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\PrivateFilesServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPrivateFilesController extends Controller
{
    public function __construct(
        private PrivateFilesServiceContract $privateFilesService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        return $this->privateFilesService->getFiles($request);
    }
}
