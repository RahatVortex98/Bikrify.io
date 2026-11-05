@extends('layouts.app')
@section('content')
<section class="bg-mist">
 <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 py-16 md:grid-cols-2 md:py-24">
  <div>
   <h1 class="text-4xl font-semibold leading-tight text-brand md:text-6xl">Smart software to run and grow your business.</h1>
   <p class="mt-6 max-w-lg text-lg">Online stores, order management, POS, and custom ERP, with the repeat work automated.</p>
   <div class="mt-8 flex flex-wrap gap-3">
    <a href="#demo" class="rounded-full bg-spark px-7 py-3.5 font-medium text-white hover:bg-orange-600">Get a free demo</a>
    <a href="#services" class="rounded-full border border-brand px-7 py-3.5 font-medium text-brand hover:bg-white">See services</a>
   </div>
  </div>
  <div class="rounded-3xl bg-white p-6 shadow-xl ring-1 ring-slate-200" aria-label="Sample order feed">
   <p class="mb-4 flex items-center justify-between text-sm font-medium text-brand">Order feed <span class="rounded-full bg-spark px-3 py-1 text-xs text-white">Sample data</span></p>
   @foreach([['#1042','Shipped','bg-blue-600'],['#1041','Delivered','bg-green-600'],['#1040','Confirming','bg-spark'],['#1039','Returned','bg-red-600']] as [$id,$st,$c])
    <div class="mb-2 flex items-center justify-between rounded-2xl bg-mist px-4 py-3"><span class="font-medium text-brand">Order {{ $id }}</span><span class="rounded-full {{ $c }} px-3 py-1 text-xs text-white">{{ $st }}</span></div>
   @endforeach
   <p class="mt-3 text-xs">Every order, courier, and return in one place.</p>
  </div>
 </div>
</section>
<section id="services" class="mx-auto max-w-6xl px-5 py-16">
 <h2 class="text-3xl font-semibold text-brand">What we build</h2>
 <div class="mt-8 grid gap-6 md:grid-cols-3">
  @foreach($services as $n)
   <a href="{{ route('service',$n) }}" class="group rounded-3xl border border-slate-200 p-7 hover:border-brand">
    <h3 class="text-xl font-medium text-brand">{{ $n->title }}</h3>
    <p class="mt-3 text-sm">{{ $n->tagline }}</p>
    <p class="mt-5 text-sm font-medium text-spark group-hover:underline">Read more</p>
   </a>
  @endforeach
 </div>
</section>
@include('partials.pricing')
<section class="bg-mist py-16"><div class="mx-auto max-w-6xl px-5">
 <h2 class="text-3xl font-semibold text-brand">Automation built in</h2>
 <div class="mt-8 grid gap-5 md:grid-cols-2">
  @foreach(['Order confirmations by SMS or WhatsApp','Courier booking and delivery tracking','Low-stock and return alerts','Daily sales reports to your inbox','New demo requests routed to our team instantly','Auto-reply to every customer enquiry'] as $a)
   <p class="flex gap-3 rounded-2xl bg-white p-5"><span class="mt-1.5 h-3 w-3 shrink-0 rounded-full bg-spark"></span>{{ $a }}</p>
  @endforeach
 </div>
</div></section>
@include('partials.form')
@endsection
