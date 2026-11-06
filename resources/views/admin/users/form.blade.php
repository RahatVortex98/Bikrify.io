@extends('layouts.admin')
@section('title',$user->exists ? 'Edit user' : 'Add admin')
@section('content')
<div class="mx-auto max-w-3xl px-5 py-10">
 <a href="{{ route('admin.users.index') }}" class="text-brand underline">Back to users</a>
 <h1 class="mt-4 text-3xl font-semibold text-brand">{{ $user->exists ? 'Edit user' : 'Add admin' }}</h1>
 @if($errors->any())<div role="alert" class="mt-4 rounded-xl bg-red-50 p-4 text-red-800"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
 <form method="post" action="{{ $user->exists ? route('admin.users.update',$user) : route('admin.users.store') }}" class="mt-6 grid gap-5">
  @csrf @if($user->exists) @method('PUT') @endif
  <label class="grid gap-2">Name<input name="name" value="{{ old('name',$user->name) }}" required maxlength="255" autocomplete="name" class="rounded-xl border border-slate-300 px-4 py-3"></label>
  <label class="grid gap-2">Email<input type="email" name="email" value="{{ old('email',$user->email) }}" required maxlength="255" autocomplete="username" class="rounded-xl border border-slate-300 px-4 py-3"></label>
  <label class="grid gap-2">{{ $user->exists ? 'New password (leave blank to keep current password)' : 'Password' }}<input type="password" name="password" minlength="12" {{ $user->exists ? '' : 'required' }} autocomplete="new-password" class="rounded-xl border border-slate-300 px-4 py-3"><span class="text-sm text-slate-600">At least 12 characters.</span></label>
  <label class="grid gap-2">Confirm password<input type="password" name="password_confirmation" minlength="12" {{ $user->exists ? '' : 'required' }} autocomplete="new-password" class="rounded-xl border border-slate-300 px-4 py-3"></label>
  <button class="w-fit rounded-full bg-spark px-6 py-3 font-medium text-white">{{ $user->exists ? 'Save changes' : 'Create admin' }}</button>
 </form>
</div>
@endsection
