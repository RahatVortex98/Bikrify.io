<section id="pricing" class="mx-auto max-w-6xl px-5 py-16">
 <div class="max-w-2xl">
  <h2 class="text-3xl font-semibold text-brand">Two ways to work with us</h2>
  <p class="mt-3">Both options cover all our services: online store and orders, POS and inventory, and custom ERP. No hidden packages. Tell us what you need and we send a clear quote.</p>
 </div>

 <div class="mt-10 grid gap-6 md:grid-cols-2">
  {{-- Monthly subscription --}}
  <article class="flex flex-col rounded-3xl border-2 border-brand bg-white p-8">
   <h3 class="text-2xl font-semibold text-brand">Monthly subscription</h3>
   <p class="mt-2 text-ink">Start fast with a small monthly fee. We host, maintain, and support it.</p>
   <ul class="mt-6 flex-1 space-y-3">
    @foreach(['Low upfront cost','Hosting, updates, and backups included','Support and fixes whenever you need them','Add modules as your business grows','Service pauses if the monthly fee is unpaid (see Rules & Policies)'] as $i)
     <li class="flex gap-3"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-spark"></span>{{ $i }}</li>
    @endforeach
   </ul>
   <a href="#demo" class="mt-8 rounded-full bg-spark px-6 py-3.5 text-center font-medium text-white hover:bg-orange-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand">Contact us for a quote</a>
  </article>

  {{-- One-time purchase --}}
  <article class="flex flex-col rounded-3xl bg-brand p-8 text-white">
   <h3 class="text-2xl font-semibold">Get it all: one-time purchase</h3>
   <p class="mt-2 text-blue-100">Pay once and get the full system built for you.</p>
   <ul class="mt-6 flex-1 space-y-3">
    @foreach(['Full setup and delivery of the services you choose','Your own branding and domain','Training for you and your team','Hosting and maintenance available as an optional add-on'] as $i)
     <li class="flex gap-3"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-spark"></span>{{ $i }}</li>
    @endforeach
   </ul>
   <a href="#demo" class="mt-8 rounded-full bg-white px-6 py-3.5 text-center font-medium text-brand hover:bg-mist focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Contact us for a quote</a>
  </article>
 </div>

 <p class="mt-6 text-sm">Not sure which fits? <a class="font-medium text-brand underline" href="https://wa.me/{{ config('bikrify.whatsapp') }}">Message us on WhatsApp</a> and we will help you choose. Read our <a class="font-medium text-brand underline" href="/policies">Rules &amp; Policies</a>.</p>
</section>
