@extends('layouts.app')
@section('title',$t.' | Bikrify')
@section('content')
<div class="mx-auto max-w-3xl px-5 py-20"><h1 class="text-4xl font-semibold text-brand">{{ $t }}</h1><p class="mt-5 text-lg">{{ $b }}</p><a href="/#demo" class="mt-8 inline-block rounded-full bg-spark px-7 py-3 font-medium text-white">Talk to us</a></div>
@endsection
