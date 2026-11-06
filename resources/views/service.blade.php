@extends('layouts.app')
@section('title',$s->data['seo_title'])
@section('desc',$s->data['meta_description'])
@push('structured-data')
@php
 $serviceSchema=['@context'=>'https://schema.org','@type'=>'Service','name'=>$s->title,'description'=>$s->intro,'provider'=>['@type'=>'Organization','name'=>'Bikrify','url'=>route('home')],'areaServed'=>['@type'=>'Country','name'=>'Bangladesh'],'url'=>route('service',$s)];
 $faqSchema=['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>collect($s->data['faq'])->map(fn($faq)=>['@type'=>'Question','name'=>$faq[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$faq[1]]])->values()->all()];
@endphp
<script type="application/ld+json">{!! Illuminate\Support\Js::encode($serviceSchema) !!}</script>
<script type="application/ld+json">{!! Illuminate\Support\Js::encode($faqSchema) !!}</script>
@endpush
@section('content')
<section class="bg-mist"><div class="mx-auto max-w-6xl px-5 py-14 md:py-20">
 <p class="text-sm"><a class="hover:text-brand" href="{{ route('home') }}">Home</a> / <a class="hover:text-brand" href="{{ route('home') }}#services">Services</a> / {{ $s->title }}</p>
 <h1 class="mt-5 max-w-3xl text-4xl font-semibold leading-tight text-brand md:text-5xl">{{ $s->data['h1'] }}</h1>
 <p class="mt-4 max-w-2xl text-xl text-ink">{{ $s->tagline }}</p>
 <p class="mt-4 max-w-2xl">{{ $s->intro }}</p>
 <a href="#demo" class="mt-8 inline-block rounded-full bg-spark px-7 py-3.5 font-medium text-white hover:bg-orange-600">Book a free demo</a>
</div></section>
<section class="mx-auto grid max-w-6xl gap-6 px-5 py-16 md:grid-cols-2">
 <div class="rounded-3xl border border-slate-200 p-7"><h2 class="text-xl font-medium text-brand">Problems we remove</h2>
  <ul class="mt-4 space-y-3">@foreach($s->data['problems'] as $p)<li class="flex gap-3"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-red-500"></span>{{ $p }}</li>@endforeach</ul></div>
 <div class="rounded-3xl bg-brand p-7 text-white"><h2 class="text-xl font-medium">What you get instead</h2>
  <ul class="mt-4 space-y-3">@foreach($s->data['solutions'] as $p)<li class="flex gap-3"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-spark"></span>{{ $p }}</li>@endforeach</ul></div>
</section>
<section class="mx-auto max-w-4xl space-y-10 px-5 py-16">
 @foreach($s->data['sections'] as [$heading,$copy])
  <div><h2 class="text-2xl font-semibold text-brand">{{ $heading }}</h2><p class="mt-4 leading-8">{{ $copy }}</p></div>
 @endforeach
</section>
<section class="bg-mist py-12"><div class="mx-auto max-w-4xl px-5">
 <h2 class="text-2xl font-semibold text-brand">Explore related services</h2>
 <ul class="mt-4 flex flex-wrap gap-x-6 gap-y-3">
  @foreach($relatedServices as $related)
   <li><a class="text-brand underline" href="{{ route('service',$related) }}">{{ $related->title }}</a></li>
  @endforeach
 </ul>
</div></section>
<section class="bg-mist py-16"><div class="mx-auto max-w-6xl px-5">
 <h2 class="text-3xl font-semibold text-brand">Capabilities</h2>
 <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
  @foreach($s->data['caps'] as [$t,$d])<div class="rounded-2xl bg-white p-6"><h3 class="font-medium text-brand">{{ $t }}</h3><p class="mt-2 text-sm">{{ $d }}</p></div>@endforeach
 </div>
</div></section>
<section class="mx-auto max-w-6xl px-5 py-16">
 <h2 class="text-3xl font-semibold text-brand">How we roll it out</h2>
 <ol class="mt-8 grid gap-5 md:grid-cols-4">
  @foreach($s->data['steps'] as $i=>[$t,$d])<li class="border-l-4 border-spark pl-4"><p class="font-medium text-brand">{{ $i+1 }}. {{ $t }}</p><p class="mt-1 text-sm">{{ $d }}</p></li>@endforeach
 </ol>
</section>
<section class="mx-auto max-w-3xl px-5 pb-16">
 <h2 class="text-3xl font-semibold text-brand">Pricing</h2>
 <p class="mt-3">Pricing depends on modules, users, and branches. We give a fixed quote after a short discovery call.</p>
 <h2 class="mt-12 text-3xl font-semibold text-brand">Common questions</h2>
 <div class="mt-5 divide-y divide-slate-200 border-y border-slate-200">
  @foreach($s->data['faq'] as [$q,$a])<details class="py-4"><summary class="cursor-pointer font-medium text-brand">{{ $q }}</summary><p class="mt-2">{{ $a }}</p></details>@endforeach
 </div>
</section>
@include('partials.form')
@endsection
