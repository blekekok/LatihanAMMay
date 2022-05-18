<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $user = $this->userService->create(
            $request->university_id,
            $request->email,
            $request->password,
            $request->name,
            $request->phone,
        );

        $this->userService->addFiles($user->id, $request);

        return UserResource::make($user)->response();
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Incorrect credentials'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();

        return UserResource::make($user)->response();
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }
}
