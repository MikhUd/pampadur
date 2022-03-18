<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\PrivateFilesServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPrivateFilesController extends Controller
{
    private $privateFilesService;

    public function __construct(PrivateFilesServiceContract $privateFilesService)
    {
        $this->privateFilesService = $privateFilesService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->privateFilesService->getFiles($request);
    }
}
