@extends('layouts.admin')
@section('title','Customers & billing')
@section('content')
<div class="mx-auto max-w-7xl px-5 py-10"><h1 class="text-3xl font-semibold text-brand">Customers &amp; billing</h1>
@if(session('ok'))<p class="mt-3 break-all rounded-xl bg-green-50 p-3 text-sm text-green-800">{{ session('ok') }}</p>@endif
<a href="/admin/customers/new" class="mt-4 inline-block rounded-full bg-spark px-5 py-2 text-sm font-medium text-white">Add customer</a>
<div class="mt-4 overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-mist text-brand"><tr><th class="p-3">Customer</th><th>Plan</th><th>Status</th><th>Due</th><th>Details</th><th>Actions</th></tr></thead>
@foreach($rows as $c)<tr class="border-b align-top"><td class="p-3 font-medium">{{ $c->name }}<br><a class="text-brand underline" href="https://wa.me/88{{ preg_replace('/\D/','',$c->phone) }}">{{ $c->phone }}</a>@if($c->site_url)<br><a class="text-xs underline" href="{{ $c->site_url }}" target="_blank" rel="noopener">{{ $c->site_url }}</a>@endif</td>
<td>{{ $c->plan==='monthly'?'Monthly '.number_format($c->monthly_fee).' BDT':'Purchased '.number_format($c->price).' BDT' }}</td>
<td><span class="rounded-full px-3 py-1 text-xs text-white {{ $c->status==='active'?'bg-green-600':'bg-red-600' }}">{{ $c->status }}</span></td>
<td class="{{ $c->overdue()?'font-semibold text-red-600':'' }}">{{ $c->paid_until?->format('d M Y') ?? '-' }}</td>
<td class="text-xs">@if($c->plan==='monthly')NID ****{{ substr((string)$c->nid,-4) }}<br>{{ $c->pay_method }}: {{ $c->pay_account }}@if($c->photo)<br><a class="underline" href="/admin/customers/{{ $c->id }}/photo" target="_blank">Photo</a>@endif<br>@endif License: <code class="break-all">{{ $c->license_key }}</code></td>
<td><form method="post" action="/admin/customers/{{ $c->id }}/pay" class="flex gap-1">@csrf<input name="amount" type="number" placeholder="{{ $c->monthly_fee?:$c->price }}" class="w-24 rounded border px-2 py-1"><button class="rounded bg-brand px-2 text-white">Paid</button></form>
<form method="post" action="/admin/customers/{{ $c->id }}/toggle" class="mt-1">@csrf @method('PATCH')<button class="text-xs underline">{{ $c->status==='active'?'Suspend now':'Activate' }}</button></form></td></tr>@endforeach</table></div></div>
@endsection
