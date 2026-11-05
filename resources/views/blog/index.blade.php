@extends('layouts.app')
@section('title','Bikrify Blog | Practical Business Software Guides')
@section('desc','Practical guides for Bangladeshi businesses on online orders, inventory, POS, and choosing business software.')
@section('content')
<section class="bg-mist"><div class="mx-auto max-w-6xl px-5 py-14 md:py-20">
 <h1 class="text-4xl font-semibold text-brand md:text-5xl">Bikrify blog</h1>
 <p class="mt-4 max-w-2xl text-lg">Practical notes on managing orders, stock, and everyday business work with software.</p>
</div></section>
<section class="mx-auto max-w-6xl px-5 py-14">
 @if($posts->isEmpty())
  <p class="rounded-2xl bg-mist p-6">No articles have been published yet. Please check back later.</p>
 @else
  <div class="grid gap-6 md:grid-cols-2">
   @foreach($posts as $post)
    <article class="rounded-3xl border border-slate-200 p-7">
     <p class="text-sm text-slate-500"><time datetime="{{ $post->published_at->toAtomString() }}">{{ $post->published_at->timezone('Asia/Dhaka')->format('j M Y') }}</time></p>
     <h2 class="mt-3 text-2xl font-semibold text-brand"><a href="{{ route('blog.show',$post) }}" class="hover:underline">{{ $post->title }}</a></h2>
     <p class="mt-3">{{ $post->excerpt }}</p>
     <a class="mt-5 inline-block font-medium text-spark hover:underline" href="{{ route('blog.show',$post) }}">Read article</a>
    </article>
   @endforeach
  </div>
  <div class="mt-8">{{ $posts->links() }}</div>
 @endif
</section>
@endsection
