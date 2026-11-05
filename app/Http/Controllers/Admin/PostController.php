<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.blog.index', [
            'posts' => Post::latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.form', ['post' => new Post]);
    }

    public function store(Request $request): RedirectResponse
    {
        $post = Post::create($this->validatedData($request));

        return redirect()->route('admin.blog.edit', $post)->with('ok', 'Post created.');
    }

    public function edit(Post $post): View
    {
        return view('admin.blog.form', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $post->update($this->validatedData($request, $post));

        return redirect()->route('admin.blog.edit', $post)->with('ok', 'Post updated.');
    }

    private function validatedData(Request $request, ?Post $post = null): array
    {
        $slug = $request->input('slug');
        if (! is_string($slug) || trim($slug) === '') {
            $slug = $request->input('title');
        }

        $request->merge([
            'slug' => is_string($slug) ? Str::slug($slug) : '',
        ]);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:60'],
            'slug' => ['required', 'string', 'max:180', Rule::unique('posts', 'slug')->ignore($post)],
            'excerpt' => ['required', 'string', 'max:300'],
            'meta_description' => ['required', 'string', 'max:155'],
            'body' => ['required', 'string', 'min:100', 'max:100000'],
            'published_at' => ['nullable', 'date_format:Y-m-d\TH:i'],
        ]);

        $data['published_at'] = $data['published_at']
            ? Carbon::createFromFormat('Y-m-d\TH:i', $data['published_at'], 'Asia/Dhaka')->utc()
            : null;

        return $data;
    }
}
