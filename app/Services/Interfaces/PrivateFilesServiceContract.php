<?php

namespace App\Services\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface PrivateFilesServiceContract
{
    public function getFiles(Request $request): JsonResponse;
}
