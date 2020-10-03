<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\UserResource;

class UserController extends Controller
{
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
