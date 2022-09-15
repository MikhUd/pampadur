<?php

namespace App\Services\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface PrivateFilesServiceContract
{
    /**
     * Получение приватных файлов.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFiles(Request $request): JsonResponse;
}
