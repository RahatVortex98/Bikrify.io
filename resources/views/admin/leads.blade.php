@extends('layouts.admin')
@section('title','Leads | Bikrify')
@section('content')
<div class="mx-auto max-w-6xl px-5 py-12"><h1 class="mb-6 text-3xl font-semibold text-brand">Demo requests</h1>
<div class="overflow-x-auto"><table class="w-full text-left text-sm">
 <thead class="bg-mist text-brand"><tr><th class="p-3">Date</th><th>Name</th><th>Phone</th><th>Business</th><th>Interest</th><th>Status</th><th></th></tr></thead>
 @foreach($leads as $l)<tr class="border-b"><td class="p-3">{{ $l->created_at->format('d M, h:i A') }}</td><td>{{ $l->name }}</td>
  <td><a class="text-brand underline" href="https://wa.me/{{ preg_replace('/\D/','',$l->phone) }}">{{ $l->phone }}</a></td><td>{{ $l->business }}</td><td>{{ $l->service }}</td><td>{{ $l->status }}</td>
  <td>@if($l->status==='new')<form method="post" action="{{ route('leads.mark',$l) }}">@csrf @method('PATCH')<button class="rounded-full bg-brand px-3 py-1 text-white">Mark contacted</button></form>@endif</td></tr>@endforeach
</table></div>{{ $leads->links() }}</div>
@endsection
