<?php

namespace App\Http\Controllers\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meeting\IndexMeetingRequest;
use App\Services\Interfaces\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function __construct(
        private UserServiceContract $userService
    ) {}


}
