@extends('layouts.admin')
@section('title',$item->exists ? 'Edit homepage card' : 'Add homepage card')
@section('content')
<div class="mx-auto max-w-3xl px-5 py-10">
 <a href="{{ route('admin.home-build.index') }}" class="text-sm text-brand underline">Back to homepage cards</a>
 <h1 class="mt-4 text-3xl font-semibold text-brand">{{ $item->exists ? 'Edit homepage card' : 'Add homepage card' }}</h1>
 @if($errors->any())<div role="alert" class="mt-4 rounded-xl bg-red-50 p-4 text-sm text-red-800"><ul class="list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
 <form method="post" action="{{ $item->exists ? route('admin.home-build.update',$item) : route('admin.home-build.store') }}" class="mt-6 grid gap-5">
  @csrf
  @if($item->exists) @method('PUT') @endif
  <label class="grid gap-1 text-sm font-medium text-brand">Card title<input name="title" value="{{ old('title',$item->title) }}" maxlength="120" required class="rounded-xl border border-slate-300 px-4 py-3 font-normal text-ink"></label>
  <label class="grid gap-1 text-sm font-medium text-brand">Short description<textarea name="description" rows="3" maxlength="500" required class="rounded-xl border border-slate-300 px-4 py-3 font-normal text-ink">{{ old('description',$item->description) }}</textarea></label>
  <label class="grid gap-1 text-sm font-medium text-brand">Link<input name="url" value="{{ old('url',$item->url) }}" maxlength="2048" placeholder="/services/your-service or https://example.com" required class="rounded-xl border border-slate-300 px-4 py-3 font-normal text-ink"><span class="font-normal text-slate-600">Use a site path beginning with /, an https:// link, or a page anchor beginning with #.</span></label>
  <label class="grid gap-1 text-sm font-medium text-brand">Display order<input name="sort" type="number" min="0" max="65535" value="{{ old('sort',$item->sort ?? 0) }}" required class="w-40 rounded-xl border border-slate-300 px-4 py-3 font-normal text-ink"></label>
  <div class="flex flex-wrap gap-3"><button class="rounded-full bg-spark px-6 py-3 font-medium text-white">Save card</button><a href="{{ route('admin.home-build.index') }}" class="rounded-full border border-slate-300 px-6 py-3 font-medium text-brand">Cancel</a></div>
 </form>
</div>
@endsection
