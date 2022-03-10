<?php

namespace App\Http\Controllers\DatingCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DatingCard\CreateDatingCardRequest;
use App\Services\Interfaces\DatingCardServiceContract;
use Illuminate\Http\Request;

class DatingCardController extends Controller
{
    private $datingCardService;

    public function __construct(DatingCardServiceContract $datingCardService)
    {
        $this->datingCardService = $datingCardService;
    }

    public function store(CreateDatingCardRequest $request)
    {
        dd($request->toArray());
    }

    public function update($request)
    {

    }
}
