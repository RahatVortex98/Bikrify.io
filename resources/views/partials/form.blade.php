<section id="demo" class="bg-brand py-16">
 <div class="mx-auto grid max-w-6xl gap-10 px-5 md:grid-cols-2">
  <div class="text-white">
   <h2 class="text-3xl font-semibold leading-tight md:text-4xl">See it with your own products.</h2>
   <p class="mt-4 max-w-md text-blue-100">Book a free 5-minute demo. We reply within one business day, no pressure and no confusing tech talk.</p>
  </div>
  <form method="post" action="{{ route('demo') }}" class="grid gap-4 rounded-3xl bg-white p-6">
   @csrf
   @if(session('ok'))<p role="status" class="rounded-xl bg-green-50 p-3 text-sm text-green-800">{{ session('ok') }}</p>@endif
   <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
   @foreach([['name','Your name','text',true],['phone','Phone or WhatsApp','tel',true],['email','Email (optional)','email',false],['business','Business name (optional)','text',false]] as [$f,$l,$t,$req])
    <label class="grid gap-1 text-sm font-medium text-brand">{{ $l }}
     <input type="{{ $t }}" name="{{ $f }}" value="{{ old($f) }}" @required($req) class="rounded-xl border border-slate-300 px-4 py-3 font-normal text-slate-800 focus:border-brand focus:outline-2 focus:outline-brand">
     @error($f)<span class="text-xs font-normal text-red-600">{{ $message }}</span>@enderror
    </label>
   @endforeach
   <label class="grid gap-1 text-sm font-medium text-brand">What do you need?
    <select name="service" class="rounded-xl border border-slate-300 px-4 py-3 font-normal text-slate-800">
     @foreach($services as $n)<option @selected(old('service',$s->title??'')==$n->title)>{{ $n->title }}</option>@endforeach
     <option>Not sure yet</option>
    </select>
   </label>
   <button class="rounded-full bg-spark px-6 py-3.5 font-medium text-white hover:bg-orange-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand">Book my free demo</button>
  </form>
 </div>
</section>
