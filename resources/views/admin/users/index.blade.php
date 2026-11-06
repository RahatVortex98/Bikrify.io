@extends('layouts.admin')
@section('title','Users & admins')
@section('content')
<div class="mx-auto max-w-6xl px-5 py-10">
 <div class="flex flex-wrap items-center justify-between gap-4"><h1 class="text-3xl font-semibold text-brand">Users & admins</h1><a href="{{ route('admin.users.create') }}" class="rounded-full bg-spark px-5 py-3 font-medium text-white">Add admin</a></div>
 @if(session('ok'))<p role="status" class="mt-4 rounded-xl bg-green-50 p-3 text-green-800">{{ session('ok') }}</p>@endif
 <div class="mt-6 overflow-x-auto"><table class="w-full text-left text-sm">
  <thead><tr class="border-b border-slate-200"><th class="p-3">Name</th><th class="p-3">Email</th><th class="p-3">Access</th><th class="p-3">Actions</th></tr></thead>
  <tbody>@foreach($users as $user)<tr class="border-b border-slate-200"><td class="p-3">{{ $user->name }}{{ $user->is(auth()->user()) ? ' (you)' : '' }}</td><td class="p-3">{{ $user->email }}</td><td class="p-3">{{ $user->is_admin ? 'Admin' : 'User' }}</td><td class="p-3"><a href="{{ route('admin.users.edit',$user) }}" class="text-brand underline">Edit / change password</a></td></tr>@endforeach</tbody>
 </table></div>
 <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
