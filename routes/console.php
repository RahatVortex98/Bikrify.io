<?php
use App\Models\Lead;
use Illuminate\Support\Facades\{Mail,Schedule};
Schedule::call(function(){
 $l=Lead::where('status','new')->where('created_at','<',now()->subDay())->get();
 if($l->isNotEmpty()) Mail::raw($l->count()." lead(s) waiting over 24h:\n".$l->map(fn($x)=>"- {$x->name} {$x->phone}")->join("\n"),
  fn($m)=>$m->to(config('bikrify.admin_email'))->subject('Bikrify: leads waiting'));
})->dailyAt('09:00')->name('stale-leads');
Schedule::call(function(){
 $late=\App\Models\Customer::where('plan','monthly')->where('status','active')->whereDate('paid_until','<',today())->get();
 $late->each->update(['status'=>'suspended']);
 $soon=\App\Models\Customer::where('plan','monthly')->where('status','active')->whereBetween('paid_until',[today(),today()->addDays(3)])->get();
 if($late->isNotEmpty()||$soon->isNotEmpty()) Mail::raw("Suspended today (unpaid):\n".$late->map(fn($c)=>"- {$c->name} {$c->phone}")->join("\n")."\n\nDue within 3 days:\n".$soon->map(fn($c)=>"- {$c->name} {$c->phone} ({$c->paid_until->format('d M')})")->join("\n"),
  fn($m)=>$m->to(config('bikrify.admin_email'))->subject('Bikrify: monthly fee report'));
})->dailyAt('00:10')->name('billing');
