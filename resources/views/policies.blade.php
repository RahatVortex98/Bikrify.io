@extends('layouts.app')
@section('title','Rules & Policies | Bikrify')
@section('content')
@php
$sections=[
 'Monthly plan: payment and suspension'=>[
  "The monthly fee is due on the due date shown in your agreement and dashboard.",
  "If the fee is not paid by the due date, your site or system is suspended automatically. It shows a paused page until payment is recorded.",
  "Your data is not deleted during suspension. Access returns shortly after we record your payment.",
  "If the account stays unpaid for 60 days, Bikrify may end the service and remove hosted data.",
 ],
 'One-time purchase'=>[
  "A one-time purchase covers the setup and delivery of your site or system as agreed in writing.",
  "Hosting, maintenance, and extra features are separate unless your agreement says otherwise.",
 ],
 'Payments and refunds'=>[
  "We accept bKash, Nagad, and bank transfer to the accounts Bikrify provides.",
  "Payments are recorded within one business day.",
  "Setup and purchase fees are non-refundable after delivery. Monthly fees are non-refundable for months already used.",
 ],
 'Your responsibilities'=>[
  "Give us accurate business and payment information.",
  "Sell only lawful products and services.",
  "Do not remove, bypass, or tamper with the billing and license checks. Doing so is a breach of these terms and may end the service.",
 ],
 'Data and privacy'=>[
  "For monthly plans we collect your NID number, photo, and payment account to verify identity and manage billing.",
  "This information is stored encrypted, used only for identity and billing, and shared only when the law requires it.",
  "You can ask us to delete your data after your agreement ends, where the law allows.",
 ],
];
@endphp
<div class="mx-auto max-w-3xl px-5 py-16">
 <h1 class="text-4xl font-semibold text-brand">Rules &amp; Policies</h1>
 <p class="mt-3 text-sm">Last updated {{ date('F Y') }}. These terms apply to Bikrify customers.</p>
 @foreach($sections as $title=>$items)
  <h2 class="mt-10 text-2xl font-medium text-brand">{{ $title }}</h2>
  <ul class="mt-3 space-y-3">@foreach($items as $i)<li class="flex gap-3"><span class="mt-2.5 h-2 w-2 shrink-0 rounded-full bg-spark"></span>{{ $i }}</li>@endforeach</ul>
 @endforeach
 <p class="mt-12">Questions? <a class="text-brand underline" href="mailto:{{ config('bikrify.email') }}">{{ config('bikrify.email') }}</a></p>
</div>
@endsection
