<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UniversityResource;
use App\Models\University;

class UniversityController extends Controller
{
    public function index(): JsonResponse
    {
        $universities = University::all();

        return UniversityResource::collection($universities)->response();
    }

}
