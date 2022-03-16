<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\PrivateFilesServiceContract;
use App\Services\PrivateFilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPrivateFilesController extends Controller
{
    private function getPrivateFilesService()
    {
        return app(PrivateFilesServiceContract::class);
    }
    public function __invoke(Request $request): JsonResponse
    {
        return $this->getPrivateFilesService()->getFiles($request);
    }
}
