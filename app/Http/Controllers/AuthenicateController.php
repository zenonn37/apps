<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AuthenicateController extends Controller
{


    public function register(UserRequest $request)
    {

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->name);

        $user->save();

        return new UserResource($user);
    }
}
