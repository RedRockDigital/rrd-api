<?php

namespace RedRockDigital\Api\Http\Controllers\Blog;

use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Models\Blog;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'blogs.index' => false,
        'blogs.show'  => false,
    ];

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->response->paginate(
            Blog::where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->paginate(12)
        );
    }

    /**
     * @param  Blog  $blog
     * @return JsonResponse
     */
    public function show(Blog $blog): JsonResponse
    {
        return $this->response->respond($blog);
    }
}
