<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\UrlGenerator;
use App\Http\Requests\BasicUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class AdminController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
    }

    public function getDashboard(): JsonResponse
    {
        $users = User::where('approval', 'Pending')->get();
        $totalApproved = User::where('approval', 'Approved')->count();
        $totalPending = User::where('approval', 'Pending')->count();

        foreach($users as $user) {
            $baseUrl = $this->url->to('/storage');
            $user->image_url = $baseUrl.'/'.$user->image_url;
        }

        return response()->json([
            'users' => UserResource::collection($users),
            'totalApproved' => $totalApproved,
            'totalPending' => $totalPending
        ], 200);
    }

    public function userApprove(BasicUserRequest $request): JsonResponse
    {
        $user = $this->userUpdateApproval($request->id, 'Approved');

        return response()->json([
            'message' => 'User Approved'
        ]);
    }

    public function userReject(BasicUserRequest $request): JsonResponse
    {
        $user = $this->userUpdateApproval($request->id, 'Rejected');

        return response()->json([
            'message' => 'User Rejected'
        ]);
    }

    public function userUpdateApproval($id, $status)
    {
        return User::where('id', $id)->update(array('approval' => $status));
    }
}
