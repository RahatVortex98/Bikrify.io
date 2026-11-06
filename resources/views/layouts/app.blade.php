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
   <a class="hover:text-brand" href="{{ route('blog.index') }}">Blog</a>
  </nav>
  <div class="flex items-center gap-4">
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
   <form method="post" action="/subscribe" class="flex gap-2">@csrf<input type="email" name="email" required placeholder="Your email" aria-label="Email" class="min-w-0 flex-1 rounded-full border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder:text-slate-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"><button class="rounded-full bg-spark px-4 py-2 font-medium text-white">Subscribe</button></form>
   @if(session('sub'))<p role="status" class="mt-2 text-xs text-green-300">{{ session('sub') }}</p>@endif
   <p class="mt-5">&#128222; {{ config('bikrify.phone') }}</p><p class="mt-2">&#128205; {{ config('bikrify.address') }}</p></div>
 </div>
 <p class="border-t border-white/10 py-5 text-center text-xs">&copy; {{ date('Y') }} Bikrify</p>
</footer>
<a href="https://wa.me/{{ config('bikrify.whatsapp') }}?text=Hi%20Bikrify%2C%20I%20want%20a%20free%20demo" class="whatsapp-contact fixed bottom-5 right-5 z-40 inline-flex items-center gap-2 rounded-full bg-[#25D366] px-5 py-3 text-sm font-medium text-white shadow-lg focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-brand">
 <svg aria-hidden="true" class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M20.52 3.48A11.9 11.9 0 0 0 12.05 0C5.47 0 .11 5.35.1 11.94c0 2.1.55 4.16 1.6 5.98L0 24l6.24-1.64a11.96 11.96 0 0 0 5.8 1.48h.01c6.58 0 11.94-5.35 11.95-11.94a11.87 11.87 0 0 0-3.48-8.42ZM12.05 21.8a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.7.97.99-3.61-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.46 4.45-9.9 9.92-9.9a9.83 9.83 0 0 1 7 2.9 9.83 9.83 0 0 1 2.9 7c-.01 5.46-4.46 9.9-9.96 9.9Zm5.43-7.42c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.8-1.49-1.78-1.66-2.08-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.09 4.49.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.42.25-.7.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z"/></svg>
 <span>WhatsApp us</span>
</a>
</body></html>
