<?php
namespace App\Jobs;
use App\Models\Lead;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
class ProcessLead implements ShouldQueue {
 use Queueable;
 public function __construct(public Lead $lead) {}
 public function handle(): void {
  $l=$this->lead;
  Mail::raw("New demo request\n\nName: {$l->name}\nPhone: {$l->phone}\nEmail: {$l->email}\nBusiness: {$l->business}\nInterest: {$l->service}\n\n{$l->message}\n\nWhatsApp: https://wa.me/".preg_replace('/\D/','',$l->phone),
   fn($m)=>$m->to(config('bikrify.admin_email'))->subject("Bikrify lead: {$l->name}"));
  if ($l->email) Mail::raw("Hi {$l->name},\n\nThanks for contacting Bikrify. We received your request and will reach out within one business day to set up your free demo.\n\nBikrify team",
   fn($m)=>$m->to($l->email)->subject('We got your demo request'));
 }
}
