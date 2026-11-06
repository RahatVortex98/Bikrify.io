<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
 <title>@yield('title','E-commerce Software Company Bangladesh | Bikrify')</title>
 <meta name="description" content="@yield('desc','Bikrify helps Bangladeshi businesses manage online orders, shop operations, and stock with software shaped around their work.')">
 <link rel="canonical" href="@yield('canonical', url()->current())">
 <meta property="og:title" content="@yield('title','E-commerce Software Company Bangladesh | Bikrify')">
 <meta property="og:description" content="@yield('desc','Bikrify helps Bangladeshi businesses manage online orders, shop operations, and stock with software shaped around their work.')">
 <meta property="og:url" content="@yield('canonical', url()->current())"><meta property="og:type" content="@yield('ogType','website')">
 <meta property="og:image" content="{{ asset('og-image.jpg') }}"><meta property="og:locale" content="en_BD">
 <meta name="twitter:card" content="summary_large_image">
 <meta name="twitter:title" content="@yield('title','E-commerce Software Company Bangladesh | Bikrify')">
 <meta name="twitter:description" content="@yield('desc','Bikrify helps Bangladeshi businesses manage online orders, shop operations, and stock with software shaped around their work.')">
 <meta name="twitter:image" content="{{ asset('og-image.jpg') }}">
 <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
 @vite(['resources/css/app.css','resources/js/app.js'])
 @php($organizationSchema=['@context'=>'https://schema.org','@type'=>'Organization','name'=>'Bikrify','description'=>'Bikrify builds online stores, order management, POS, and custom ERP for Bangladeshi sellers and growing businesses.','url'=>route('home'),'logo'=>asset('og-image.jpg'),'telephone'=>config('bikrify.phone'),'address'=>['@type'=>'PostalAddress','streetAddress'=>config('bikrify.address'),'addressCountry'=>'BD']])
 <script type="application/ld+json">{!! Illuminate\Support\Js::encode($organizationSchema) !!}</script>
 @stack('structured-data')
</head>
<body class="bg-white font-sans text-slate-700 antialiased">
<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
 <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-3">
  <a href="{{ route('home') }}" aria-label="Bikrify home"><x-logo/></a>
  <nav class="hidden items-center gap-7 text-sm md:flex">
   @foreach($services as $n)<a class="hover:text-brand" href="{{ route('service',$n) }}">{{ $n->data['nav_title'] ?? $n->title }}</a>@endforeach
   <a class="hover:text-brand" href="{{ route('home') }}#pricing">Pricing</a>
   <a class="font-medium text-brand hover:underline" href="{{ route('blog.index') }}">Blog</a>
  </nav>
  <div class="flex items-center gap-4">
   <a class="text-sm font-medium text-brand hover:underline md:hidden" href="{{ route('blog.index') }}">Blog</a>
   <a href="{{ route('home') }}#demo" class="rounded-full bg-spark px-5 py-2.5 text-sm font-medium text-white hover:bg-orange-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand">Get a free demo</a>
  </div>
 </div>
</header>
<main>@yield('content')</main>
<footer class="bg-ink text-slate-300">
 <div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 sm:grid-cols-2 lg:grid-cols-4">
  <div><x-logo :dark="true"/><p class="mt-4 max-w-xs text-sm">Software that runs your orders, stock, and accounts, so you can focus on growing.</p>
   <p class="mt-5 text-sm">&#128737;&#65039; Secure by design &nbsp;|&nbsp; &#128274; Encrypted sensitive data</p></div>
  <div class="text-sm"><p class="mb-3 font-medium text-white">Solutions</p><p class="mb-2 text-xs text-slate-400">By industry</p>
   <a class="block py-1 hover:text-white" href="{{ route('service','custom-erp-software-bangladesh') }}">Manufacturing</a>
   <a class="block py-1 hover:text-white" href="{{ route('service','custom-erp-software-bangladesh') }}">Logistics</a>
   <a class="block py-1 hover:text-white" href="{{ route('service','order-management-system-for-facebook-sellers') }}">E-commerce Retail</a></div>
  <div class="text-sm"><p class="mb-3 font-medium text-white">Resources</p><p class="mb-2 text-xs text-slate-400">Company</p>
   <a class="block py-1 hover:text-white" href="{{ route('blog.index') }}">Blog</a><a class="block py-1 hover:text-white" href="/case-studies">Case Studies</a><a class="block py-1 hover:text-white" href="/security">Security Center</a><a class="block py-1 hover:text-white" href="/status">System Status</a>
   <p class="mb-2 mt-5 text-xs text-slate-400">Legal</p>
   <a class="block py-1 hover:text-white" href="/policies">Rules &amp; Policies</a></div>
  <div class="text-sm"><p class="mb-3 font-medium text-white">Ready to scale?</p>
   <form method="post" action="/subscribe" class="flex gap-2">@csrf<input type="email" name="email" required placeholder="Your email" aria-label="Email" class="min-w-0 flex-1 rounded-full border-0 px-4 py-2 text-slate-800"><button class="rounded-full bg-spark px-4 py-2 font-medium text-white">Subscribe</button></form>
   @if(session('sub'))<p role="status" class="mt-2 text-xs text-green-300">{{ session('sub') }}</p>@endif
   <p class="mt-5">&#128222; {{ config('bikrify.phone') }}</p><p class="mt-2">&#128205; {{ config('bikrify.address') }}</p></div>
 </div>
 <p class="border-t border-white/10 py-5 text-center text-xs">&copy; {{ date('Y') }} Bikrify</p>
</footer>
<a href="https://wa.me/{{ config('bikrify.whatsapp') }}?text=Hi%20Bikrify%2C%20I%20want%20a%20free%20demo" class="fixed bottom-5 right-5 z-40 rounded-full bg-[#25D366] px-5 py-3 text-sm font-medium text-white shadow-lg">WhatsApp us</a>
</body></html>
