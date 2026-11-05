@extends('layouts.admin')
@section('title','Customer hunting')
@section('content')
<div class="mx-auto max-w-7xl px-5 py-10"><h1 class="text-3xl font-semibold text-brand">Customer hunting</h1>
@if(session('ok'))<p class="mt-3 rounded-xl bg-green-50 p-3 text-sm text-green-800">{{ session('ok') }}</p>@endif
@if($errors->has('file'))<p role="alert" class="mt-3 rounded-xl bg-red-50 p-3 text-sm text-red-800">{{ $errors->first('file') }}</p>@endif
<form method="post" action="/admin/prospects/import" enctype="multipart/form-data" class="mt-5 flex flex-wrap items-center gap-3 rounded-2xl bg-mist p-4 text-sm">@csrf
 <input type="file" name="file" accept=".xlsx,.xls,.csv" required><button class="rounded-full bg-spark px-5 py-2 font-medium text-white">Upload Excel</button>
 <span>Excel or CSV, up to 20 MB. We detect common name, phone, page-link, and follower headings and infer lead details from the rows when headings vary. Duplicates are updated.</span></form>
<div class="mt-6 flex flex-wrap gap-2">@foreach($stages as $k=>$l)<a href="?stage={{ $k }}" class="rounded-full px-4 py-1.5 text-sm {{ $stage===$k?'bg-brand text-white':'border text-brand' }}">{{ $l }} ({{ $counts[$k]??0 }})</a>@endforeach<a href="/admin/customers" class="rounded-full border px-4 py-1.5 text-sm text-brand">Customers (won)</a></div>
<div class="mt-4 overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-mist text-brand"><tr><th class="p-3">Page</th><th>Followers</th><th>Contact</th><th>Notes / stage</th><th></th></tr></thead>
@foreach($rows as $p)<tr class="border-b align-top"><td class="p-3 font-medium">{{ $p->page_name }}@if($p->fb_link)<br><a class="text-xs text-brand underline" href="{{ $p->fb_link }}" target="_blank" rel="noopener">Open page</a>@endif</td>
<td>{{ $p->followers?number_format($p->followers):'-' }}</td>
<td>@if($p->phone)<a class="text-brand underline" href="https://wa.me/88{{ $p->phone }}" target="_blank" rel="noopener">{{ $p->phone }}</a>@endif<br><span class="text-xs">{{ $p->last_contact_at?'Last: '.$p->last_contact_at->format('d M'):'Not contacted' }}</span></td>
<td><form method="post" action="/admin/prospects/{{ $p->id }}" class="grid gap-1">@csrf @method('PATCH')<textarea name="note" rows="2" class="rounded border p-1">{{ $p->note }}</textarea>
<div class="flex gap-1"><select name="stage" class="rounded border px-2 py-1">@foreach($stages as $k=>$l)<option value="{{ $k }}" @selected($p->stage===$k)>{{ $l }}</option>@endforeach</select><button class="rounded bg-brand px-3 text-white">Save</button></div></form></td>
<td><a class="rounded-full bg-spark px-3 py-1.5 text-xs text-white" href="/admin/customers/new?prospect={{ $p->id }}">Agreed: onboard</a></td></tr>@endforeach</table></div>{{ $rows->links() }}</div>
@endsection
