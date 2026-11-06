<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('blog.index', [
            'posts' => Post::published()->latest('published_at')->paginate(10),
        ]);
    }

    public function show(Post $post): View
    {
        abort_unless($post->published_at && $post->published_at->lte(now()), 404);

        return view('blog.show', [
            'post' => $post,
            'html' => Str::markdown($post->body, [
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
            ]),
        ]);
    }
}
