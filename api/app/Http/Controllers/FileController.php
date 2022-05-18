<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\UrlGenerator;
use App\Models\FileCategory;
use App\Http\Resources\FileCategoryResource;

class FileController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function index(Request $request)
    {
        return response()->json([
            $request->all()
        ], 200);
    }

    public function getCategories()
    {
        $categories = FileCategory::all();
        $url = $this->url->to('/storage');

        foreach($categories as $category){
            $image_url = $category->image_url;

            $category->image_url = $url.'/'.$image_url;
        }

        return FileCategoryResource::collection($categories)->response();
    }
}
