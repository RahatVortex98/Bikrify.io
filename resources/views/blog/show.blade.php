@extends('layouts.app')
@section('title',$post->title)
@section('desc',$post->meta_description)
@section('ogType','article')
@push('structured-data')
@php($articleSchema=['@context'=>'https://schema.org','@type'=>'Article','headline'=>$post->title,'description'=>$post->meta_description,'datePublished'=>$post->published_at->toAtomString(),'dateModified'=>$post->updated_at->toAtomString(),'mainEntityOfPage'=>route('blog.show',$post),'publisher'=>['@type'=>'Organization','name'=>'Bikrify','url'=>route('home'),'logo'=>['@type'=>'ImageObject','url'=>asset('og-image.jpg')]]])
<script type="application/ld+json">{!! Illuminate\Support\Js::encode($articleSchema) !!}</script>
@endpush
@section('content')
<article class="mx-auto max-w-3xl px-5 py-14 md:py-20">
 <p class="text-sm"><a class="text-brand hover:underline" href="{{ route('blog.index') }}">Bikrify blog</a> / <time datetime="{{ $post->published_at->toAtomString() }}">{{ $post->published_at->timezone('Asia/Dhaka')->format('j M Y') }}</time></p>
 <h1 class="mt-5 text-4xl font-semibold leading-tight text-brand md:text-5xl">{{ $post->title }}</h1>
 <p class="mt-5 text-xl">{{ $post->excerpt }}</p>
 <div class="post mt-10 max-w-none leading-8">{!! $html !!}</div>
</article>
<style>
 .post h2{font-size:1.6rem;font-weight:600;color:#1E3A8A;margin:2.2rem 0 .75rem}
 .post h3{font-size:1.2rem;font-weight:500;color:#1E3A8A;margin:1.6rem 0 .5rem}
 .post p{margin:1rem 0}
 .post ul{list-style:disc;padding-left:1.5rem;margin:1rem 0}
 .post ol{list-style:decimal;padding-left:1.5rem;margin:1rem 0}
 .post li{margin:.4rem 0}
 .post a{color:#1E3A8A;text-decoration:underline}
 .post table{width:100%;border-collapse:collapse;margin:1.5rem 0}
 .post th,.post td{border:1px solid #cbd5e1;padding:.6rem;text-align:left}
 .post blockquote{border-left:4px solid #F97316;padding-left:1rem;color:#475569}
</style>
@endsection
