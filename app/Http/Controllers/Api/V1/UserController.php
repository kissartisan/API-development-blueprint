<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;

class UserController extends Controller
{
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
