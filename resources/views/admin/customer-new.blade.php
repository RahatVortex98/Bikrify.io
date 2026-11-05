@extends('layouts.admin')
@section('title','Onboard customer')
@section('content')
<div class="mx-auto max-w-2xl px-5 py-10"><h1 class="text-3xl font-semibold text-brand">Onboard customer</h1>
@if($errors->any())<p class="mt-3 rounded-xl bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</p>@endif
<form method="post" action="/admin/customers" enctype="multipart/form-data" class="mt-6 grid gap-4">@csrf<input type="hidden" name="prospect_id" value="{{ $p->id??'' }}">
@foreach([['name','Business / page name',$p->page_name??''],['phone','Phone / WhatsApp',$p->phone??''],['site_url','Their F-commerce site URL','']] as [$f,$l,$v])
<label class="grid gap-1 text-sm font-medium text-brand">{{ $l }}<input name="{{ $f }}" value="{{ old($f,$v) }}" class="rounded-xl border px-4 py-2 font-normal"></label>@endforeach
<label class="grid gap-1 text-sm font-medium text-brand">Plan<select name="plan" id="plan" class="rounded-xl border px-4 py-2 font-normal"><option value="purchase">1. One-time purchase</option><option value="monthly">2. Monthly fee</option></select></label>
<label id="f-price" class="grid gap-1 text-sm font-medium text-brand">Price (BDT)<input name="price" type="number" value="{{ old('price') }}" class="rounded-xl border px-4 py-2 font-normal"></label>
<div id="f-monthly" class="hidden gap-4 rounded-2xl border p-4"><p class="text-sm">Monthly plan rules: if the fee is not paid by the due date, their site is suspended automatically until you record payment.</p>
@foreach([['monthly_fee','Monthly fee (BDT)','number'],['nid','NID number (stored encrypted)','text'],['pay_method','Payment method (bKash / Nagad / Bank)','text'],['pay_account','Account number they will pay from','text'],['paid_until','First due date','date']] as [$f,$l,$t])
<label class="grid gap-1 text-sm font-medium text-brand">{{ $l }}<input name="{{ $f }}" type="{{ $t }}" value="{{ old($f) }}" class="rounded-xl border px-4 py-2 font-normal"></label>@endforeach
<label class="grid gap-1 text-sm font-medium text-brand">Customer photo<input type="file" name="photo" accept="image/*"></label></div>
<button class="rounded-full bg-spark px-6 py-3 font-medium text-white">Save customer</button></form></div>
<script>const p=document.getElementById('plan');function t(){const m=p.value==='monthly';document.getElementById('f-monthly').classList.toggle('hidden',!m);document.getElementById('f-monthly').classList.toggle('grid',m);document.getElementById('f-price').style.display=m?'none':'grid'}p.onchange=t;t();</script>
@endsection
