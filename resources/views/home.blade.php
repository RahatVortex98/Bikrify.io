@extends('layouts.app')
@section('title','Bikrify: Order Management & ERP Software, Bangladesh')
@section('desc','Stop losing orders. Bikrify builds online stores, order management, POS and ERP for Bangladeshi sellers and growing businesses. Get a free demo.')
@section('content')
<section class="bg-mist">
 <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 py-16 md:grid-cols-2 md:py-24">
  <div>
   <h1 class="text-4xl font-semibold leading-tight text-brand md:text-6xl">E-commerce Software Company Bangladesh</h1>
   <p class="mt-6 max-w-lg text-lg">Bikrify is an e-commerce software company in Bangladesh helping business owners organize online orders, shop sales, and everyday operations with practical software.</p>
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
 <p class="mt-2 max-w-2xl text-slate-600">Practical software shaped around the way your business works today, with room to grow as your needs change.</p>
 <div class="mt-8 grid gap-6 md:grid-cols-3">
  @foreach($homeBuildItems as $item)
   <a href="{{ $item->url }}" class="group rounded-3xl border border-slate-200 p-7 hover:border-brand">
    <h3 class="text-xl font-medium text-brand">{{ $item->title }}</h3>
    <p class="mt-3 text-sm">{{ $item->description }}</p>
    <p class="mt-5 text-sm font-medium text-spark group-hover:underline">Read more</p>
   </a>
  @endforeach
 </div>
</section>
@include('partials.pricing')
<section class="bg-mist py-16"><div class="mx-auto max-w-6xl px-5">
 <h2 class="text-3xl font-semibold text-brand">Workflows to plan</h2>
 <div class="mt-8 grid gap-5 md:grid-cols-2">
  @foreach([
   ['Order details','Decide which product, customer, and delivery details your team needs to record.'],
   ['Customer confirmation','Agree what staff should check with a customer before preparing an order.'],
   ['Courier handoff','Set a consistent process for preparing delivery details and following up.'],
   ['Stock changes','Record sales, returns, supplier deliveries, and adjustments clearly.'],
   ['Counter sales','Map how staff enter items, apply prices, and record payments.'],
   ['Team approvals','Make it clear who reviews a request and what happens after a decision.'],
  ] as [$heading,$copy])
   <div class="rounded-2xl bg-white p-5"><h3 class="font-medium text-brand">{{ $heading }}</h3><p class="mt-2 text-sm">{{ $copy }}</p></div>
  @endforeach
 </div>
</div></section>
<section class="mx-auto max-w-6xl px-5 py-14" aria-labelledby="latest-posts-heading" data-blog-carousel>
 <div class="flex flex-wrap items-end justify-between gap-4">
  <div>
   <h2 id="latest-posts-heading" class="text-3xl font-semibold text-brand">Practical business guides and ideas</h2>
   <p class="mt-2 max-w-2xl text-slate-600">Clear advice on online orders, stock, and everyday operations for Bangladeshi business owners.</p>
  </div>
  <div class="flex items-center gap-3">
   <a href="{{ route('blog.index') }}" class="text-sm font-medium text-brand underline">All articles</a>
   @if($latestPosts->isNotEmpty())
   <button type="button" data-carousel-prev aria-label="Scroll to previous articles" aria-controls="latest-posts-track" class="rounded-full border border-slate-300 px-4 py-2 text-brand hover:border-brand focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand">&larr;</button>
   <button type="button" data-carousel-next aria-label="Scroll to more articles" aria-controls="latest-posts-track" class="rounded-full border border-slate-300 px-4 py-2 text-brand hover:border-brand focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand">&rarr;</button>
   @endif
  </div>
 </div>
 @if($latestPosts->isNotEmpty())
  <div id="latest-posts-track" data-carousel-track tabindex="0" aria-label="Latest published blog articles" class="mt-7 flex snap-x snap-mandatory gap-5 overflow-x-auto scroll-smooth pb-4">
   @foreach($latestPosts as $post)
    <article class="flex w-[min(85vw,22rem)] shrink-0 snap-start flex-col rounded-3xl border border-slate-200 p-6 hover:border-brand sm:w-[22rem]">
     <p class="text-xs text-slate-500"><time datetime="{{ $post->published_at->toAtomString() }}">{{ $post->published_at->timezone('Asia/Dhaka')->format('j M Y') }}</time></p>
     <h3 class="mt-3 text-xl font-medium text-brand"><a href="{{ route('blog.show',$post) }}" class="hover:underline">{{ $post->title }}</a></h3>
     <p class="mt-3 flex-1 text-sm">{{ $post->excerpt }}</p>
     <a href="{{ route('blog.show',$post) }}" class="mt-5 inline-block text-sm font-medium text-spark hover:underline">Read article</a>
    </article>
   @endforeach
  </div>
 @else
  <p class="mt-7 rounded-2xl bg-mist p-6">New articles are being prepared. Visit the <a href="{{ route('blog.index') }}" class="font-medium text-brand underline">blog</a> to see published posts.</p>
 @endif
</section>
<section class="mx-auto max-w-6xl space-y-8 px-5 py-16">
 <div><h2 class="text-2xl font-semibold text-brand">Software should fit the way your business works</h2>
  <p class="mt-4 leading-8">Running a business often means keeping track of customer conversations, orders, stock, payments, and delivery arrangements at the same time. When the details live in separate notebooks, spreadsheets, and chat threads, it can take effort just to understand what needs attention. Bikrify helps business owners map these everyday tasks and consider software that keeps the right information together. The aim is not to add technology for its own sake. It is to make routine work easier to follow and give the people doing it a clearer record.</p></div>
 <div><h2 class="text-2xl font-semibold text-brand">Order workflows for online sellers</h2>
  <p class="mt-4 leading-8">For a seller taking orders through social media or a website, each request needs accurate product, customer, and delivery details. A consistent order workflow can help a team review new requests, confirm details, prepare parcels, and record delivery outcomes. Staff can see the next step without relying on one person’s chat history. Planning should account for the channels your customers already use, the information your team genuinely needs, and how changes to an order are communicated. Explore our <a class="text-brand underline" href="{{ route('service','order-management-system-for-facebook-sellers') }}">order management system for Facebook sellers</a> to learn about this workflow.</p></div>
 <div><h2 class="text-2xl font-semibold text-brand">Point-of-sale and stock records</h2>
  <p class="mt-4 leading-8">A shop needs a useful record of what was sold, how it was paid for, and how the transaction affected available stock. Returns, damaged items, supplier deliveries, and stock counts also need clear handling. A point-of-sale setup can bring checkout and stock routines closer together, while staff practices remain important for accurate information. Before selecting a POS tool, list your payment methods, the products you sell, any branch differences, and the equipment you already use. Our <a class="text-brand underline" href="{{ route('service','pos-software-bangladesh') }}">POS software for Bangladesh businesses</a> page explains considerations for planning a shop workflow.</p></div>
 <div><h2 class="text-2xl font-semibold text-brand">Connected systems for growing teams</h2>
  <p class="mt-4 leading-8">As a company grows, different teams may maintain their own copies of customer, supplier, purchase, or finance information. Connecting selected workflows can reduce repeated entry, but only when people agree on how shared records are named, updated, and reviewed. A custom business system should be planned around real tasks and defined responsibilities. It should also account for data migration, access permissions, staff training, backups, and ongoing support. Our <a class="text-brand underline" href="{{ route('service','custom-erp-software-bangladesh') }}">custom ERP software in Bangladesh</a> page outlines a practical way to scope that work.</p></div>
 <div><h2 class="text-2xl font-semibold text-brand">Start with a clear business need</h2>
  <p class="mt-4 leading-8">A useful first step is to describe a task that is difficult today. Note who is involved, what information they need, where delays happen, and what a good result would look like. Then compare possible approaches, including improving the current process or adopting a focused tool. Ask how the software handles everyday cases and exceptions, what information it stores, who can access that information, and what support is included. A clear scope helps a business avoid paying for features it will not use and gives the team a sensible way to evaluate a proposed solution.</p></div>
 <div><h2 class="text-2xl font-semibold text-brand">Implementation is a shared process</h2>
  <p class="mt-4 leading-8">Introducing software involves more than installing an application. The business and its implementation partner need to agree on the workflow, review real examples, prepare any records that will be moved, and give staff time to practise. Begin with a manageable scope and collect feedback from the people using it. Decide how problems will be reported and who is responsible for updates and backups. These conversations help make expectations clear before launch and support a smoother transition for customers and staff.</p></div>
 <div><h2 class="text-2xl font-semibold text-brand">Questions to ask before choosing software</h2>
  <p class="mt-4 leading-8">Ask whether the system supports the way your team works now, which changes it requires, and how those changes will be introduced. Confirm how user access is managed, how information can be exported, what happens if a device or internet connection is unavailable, and whether your existing tools can be connected. Request a written outline of scope, costs, delivery stages, and support arrangements. The answers should be specific to your business rather than based on broad promises. Bikrify discusses your requirements before recommending a direction, so the proposed work can be understood by the people who will use it.</p></div>
 <div><h2 class="text-2xl font-semibold text-brand">Talk through your workflow</h2>
  <p class="mt-4 leading-8">Every shop and service business has its own customers, working hours, products, and way of handling requests. A short conversation can help clarify whether the main need is order tracking, counter sales, stock records, or coordination between teams. Share the steps you follow today and the changes you want to make; there is no need to have a technical specification ready. Use the demo form below to tell us how your business works, and we can discuss a suitable next step without assuming that one system fits every business.</p></div>
</div></section>
@include('partials.form')
@endsection
