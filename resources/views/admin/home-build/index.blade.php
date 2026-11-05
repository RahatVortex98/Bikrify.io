@extends('layouts.admin')
@section('title','Homepage services')
@section('content')
<div class="mx-auto max-w-7xl px-5 py-10">
 <div class="flex flex-wrap items-center justify-between gap-4">
  <div><h1 class="text-3xl font-semibold text-brand">What we build</h1><p class="mt-2">Manage the cards shown in this homepage section. Use a service URL or another safe link.</p></div>
  <a href="{{ route('admin.home-build.create') }}" class="rounded-full bg-spark px-5 py-2.5 text-sm font-medium text-white">Add a card</a>
 </div>
 @if(session('ok'))<p role="status" class="mt-5 rounded-xl bg-green-50 p-3 text-sm text-green-800">{{ session('ok') }}</p>@endif
 <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200">
  <table class="w-full text-left text-sm"><thead class="bg-mist text-brand"><tr><th class="p-3">Order</th><th>Title</th><th>Description</th><th>Link</th><th></th></tr></thead><tbody>
   @forelse($items as $item)
    <tr class="border-t border-slate-200 align-top"><td class="p-3">{{ $item->sort }}</td><td class="p-3 font-medium">{{ $item->title }}</td><td class="p-3">{{ $item->description }}</td><td class="p-3 break-all">{{ $item->url }}</td><td class="p-3 text-right"><a class="text-brand underline" href="{{ route('admin.home-build.edit',$item) }}">Edit</a><form method="post" action="{{ route('admin.home-build.destroy',$item) }}" class="mt-2" onsubmit="return confirm('Remove this homepage card?')">@csrf @method('DELETE')<button class="text-red-700 underline">Remove</button></form></td></tr>
   @empty
    <tr><td class="p-4" colspan="5">No homepage cards yet.</td></tr>
   @endforelse
  </tbody></table>
 </div>
</div>
@endsection
