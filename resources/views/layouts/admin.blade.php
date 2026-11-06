<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow"><meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Admin') | Bikrify Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-white font-sans text-slate-700 antialiased">
<header class="sticky top-0 z-30 bg-ink"><div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-5 py-3">
 <a href="/admin/prospects" aria-label="Admin home"><x-logo :dark="true"/></a>
 <nav class="flex flex-wrap gap-1 text-sm" aria-label="Admin">
  @foreach(['/admin/prospects'=>['Customer hunting','admin/prospects*'],'/admin/customers'=>['Customers & billing','admin/customers*'],'/admin/leads'=>['Website leads','admin/leads*'],'/admin/blog/posts'=>['Blog posts','admin/blog/posts*'],'/admin/homepage/what-we-build'=>['Homepage cards','admin/homepage/what-we-build*']] as $u=>[$l,$p])
   <a href="{{ $u }}" class="rounded-full px-4 py-2 {{ request()->is($p)?'bg-white text-brand':'text-slate-200 hover:bg-white/10' }}">{{ $l }}</a>
  @endforeach
 </nav>
 <a href="{{ route('home') }}" class="rounded-full bg-spark px-5 py-2 text-sm font-medium text-white hover:bg-orange-600">View main site</a>
</div></header>
<main>@yield('content')</main>
</body></html>
