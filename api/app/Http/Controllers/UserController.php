<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use App\Http\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserFileResource;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;
    protected $url;

    public function __construct(UserService $userService, UrlGenerator $url)
    {
        $this->userService = $userService;
        $this->url = $url;
    }

    public function emailExist(Request $request)
    {
        $email = $request->query('email');

        if ($email == null)
            return response()->json([
                'message' => 'Insufficient parameters'
            ], 500);

        $exist = $this->userService->emailExist($email);

        return response()->json([
            'email' => $email,
            'exist' => $exist
        ], 200);
    }

    public function getFiles(): JsonResponse
    {
        $user = Auth::user();
        $files = $user->userFiles;
        $baseUrl = $this->url->to('/storage');

        foreach($files as $file) {
            $file->file_url = $baseUrl.'/'.$file->file_url;
        }

        return UserFileResource::collection($files)->response();
    }

    public function getProfile(): JsonResponse
    {
        $user = Auth::user();

        $baseUrl = $this->url->to('/storage');
        $user->image_url = $baseUrl.'/'.$user->image_url;

        return UserResource::make($user)->response();
    }

    public function userProfile(Request $request): JsonResponse
    {
        $id = $request->query('id');

        if ($id == null)
        return response()->json([
            'message' => 'Insufficient parameters'
        ], 500);

        $auth_user = Auth::user();
        if ($auth_user->id != $id && $auth_user->role != 'Admin')
            return response()->json([
                'message' => 'Insufficient permissions'
            ], 401);

        $user = User::where('id', $id)->first();

        $baseUrl = $this->url->to('/storage');
        $user->image_url = $baseUrl.'/'.$user->image_url;

        $files = $user->userFiles;

        foreach($files as $file) {
            $file->file_url = $baseUrl.'/'.$file->file_url;
            $file->image_url = $baseUrl.'/'.$file->image_url;
        }

        return response()->json([
            'user' => UserResource::make($user),
            'files' => UserFileResource::collection($files)
        ], 200);
    }
}
