<?php

namespace App\Http\Controllers\DatingCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Services\Interfaces\DatingCardServiceContract;

class DatingCardController extends Controller
{
    private $datingCardService;

    public function __construct(DatingCardServiceContract $datingCardService)
    {
        $this->datingCardService = $datingCardService;
    }

    public function store(CreateDatingCardRequest $request)
    {
        return $this->datingCardService->store($request);
    }

    public function update($request)
    {

    }
}
