@extends('layouts.admin')
@section('title',$post->exists ? 'Edit blog post' : 'Write a blog post')
@section('content')
<div class="mx-auto max-w-3xl px-5 py-10">
 <a href="{{ route('admin.blog.index') }}" class="text-sm text-brand underline">Back to blog posts</a>
 <h1 class="mt-4 text-3xl font-semibold text-brand">{{ $post->exists ? 'Edit blog post' : 'Write a blog post' }}</h1>
 @if(session('ok'))<p role="status" class="mt-4 rounded-xl bg-green-50 p-3 text-sm text-green-800">{{ session('ok') }}</p>@endif
 @if($errors->any())<div role="alert" class="mt-4 rounded-xl bg-red-50 p-4 text-sm text-red-800"><p class="font-medium">Please correct the following:</p><ul class="mt-2 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
 <form method="post" action="{{ $post->exists ? route('admin.blog.update',$post) : route('admin.blog.store') }}" class="mt-6 grid gap-5">
  @csrf
  @if($post->exists) @method('PUT') @endif
  <label class="grid gap-1 text-sm font-medium text-brand">Title
   <input name="title" value="{{ old('title',$post->title) }}" required maxlength="60" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-800">
  </label>
  <label class="grid gap-1 text-sm font-medium text-brand">URL slug (optional)
   <input name="slug" value="{{ old('slug',$post->slug) }}" maxlength="180" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-800">
  </label>
  <label class="grid gap-1 text-sm font-medium text-brand">Excerpt
   <textarea name="excerpt" required maxlength="300" rows="3" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-800">{{ old('excerpt',$post->excerpt) }}</textarea>
  </label>
  <label class="grid gap-1 text-sm font-medium text-brand">Meta description (max 155 characters)
   <textarea name="meta_description" required maxlength="155" rows="2" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-800">{{ old('meta_description',$post->meta_description) }}</textarea>
  </label>
  <label class="grid gap-1 text-sm font-medium text-brand">Article body (plain text; separate paragraphs with blank lines)
   <textarea name="body" required minlength="100" maxlength="100000" rows="18" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-800">{{ old('body',$post->body) }}</textarea>
  </label>
  <label class="grid gap-1 text-sm font-medium text-brand">Publish date and time (leave blank to keep private)
   <input type="datetime-local" name="published_at" value="{{ old('published_at',$post->published_at?->timezone('Asia/Dhaka')->format('Y-m-d\TH:i')) }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-800">
  </label>
  <button class="w-fit rounded-full bg-spark px-6 py-3 font-medium text-white">{{ $post->exists ? 'Save changes' : 'Create post' }}</button>
 </form>
</div>
@endsection
