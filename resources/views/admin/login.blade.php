<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow">
<title>Sign in | Bikrify Admin</title>
@vite(['resources/css/app.css'])
</head><body class="min-h-screen bg-mist font-sans text-slate-800">
<main class="mx-auto max-w-md px-5 py-16">
 <a href="{{ route('home') }}" aria-label="Bikrify home"><x-logo/></a>
 <div class="mt-8 rounded-3xl border border-slate-200 bg-white p-7 shadow-lg">
  <h1 class="text-2xl font-semibold text-brand">Admin sign in</h1>
  @if($errors->any())<p role="alert" class="mt-4 text-sm text-red-700">{{ $errors->first() }}</p>@endif
  <form method="post" action="{{ route('admin.login.store') }}" class="mt-6 grid gap-5">
   @csrf
   <label class="grid gap-2">Email<input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" autofocus class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900"></label>
   <label class="grid gap-2">Password<input type="password" name="password" required autocomplete="current-password" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900"></label>
   <button class="rounded-full bg-spark px-6 py-3 font-medium text-white">Sign in</button>
  </form>
 </div>
</main></body></html>
