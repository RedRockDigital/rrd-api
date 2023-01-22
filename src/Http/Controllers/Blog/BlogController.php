<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
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
        $blogs = Blog::where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return $this->response
            ->paginate($blogs);
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
