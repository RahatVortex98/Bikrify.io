@extends('layouts.admin')
@section('title','Blog posts')
@section('content')
<div class="mx-auto max-w-7xl px-5 py-10">
 <div class="flex flex-wrap items-center justify-between gap-4">
  <div><h1 class="text-3xl font-semibold text-brand">Blog posts</h1><p class="mt-2">Drafts are private; posts with a publication date in the past are public.</p></div>
  <a href="{{ route('admin.blog.create') }}" class="rounded-full bg-spark px-5 py-2.5 text-sm font-medium text-white">Write a post</a>
 </div>
 @if(session('ok'))<p role="status" class="mt-5 rounded-xl bg-green-50 p-3 text-sm text-green-800">{{ session('ok') }}</p>@endif
 <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200">
  <table class="w-full text-left text-sm"><thead class="bg-mist text-brand"><tr><th class="p-3">Title</th><th>Status</th><th>Publication date</th><th></th></tr></thead><tbody>
   @forelse($posts as $post)
    <tr class="border-t border-slate-200"><td class="p-3 font-medium">{{ $post->title }}</td><td>{{ $post->published_at && $post->published_at->lte(now()) ? 'Published' : 'Draft / scheduled' }}</td><td>{{ $post->published_at?->timezone('Asia/Dhaka')->format('j M Y H:i') ?? 'Not scheduled' }}</td><td class="p-3 text-right"><a class="text-brand underline" href="{{ route('admin.blog.edit',$post) }}">Edit</a></td></tr>
   @empty
    <tr><td class="p-4" colspan="4">No posts yet.</td></tr>
   @endforelse
  </tbody></table>
 </div>
 <div class="mt-5">{{ $posts->links() }}</div>
</div>
@endsection
