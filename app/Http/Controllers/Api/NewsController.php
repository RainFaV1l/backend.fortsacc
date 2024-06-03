<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::query()->where('isPublished', true)->orderByDesc('created_at')->paginate(11);
        return NewsResource::collection($news);
    }

    /**
     * Display a listing of the resource.
     */
    public function show(string $id)
    {
        $news = News::query()->where('id', $id)->where('isPublished', true)->firstOrFail();
        return new NewsResource($news);
    }
}
