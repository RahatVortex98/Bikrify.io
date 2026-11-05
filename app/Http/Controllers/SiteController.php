<?php
namespace App\Http\Controllers;
use App\Jobs\ProcessLead;
use App\Models\{Lead,Service};
use Illuminate\Http\Request;
class SiteController extends Controller {
 public function home(){ return view('home'); }
 public function service(Service $service){ return view('service',['s'=>$service]); }
 public function demo(Request $r){
  if ($r->filled('website')) return back();
  $d=$r->validate(['name'=>'required|max:80','phone'=>'required|max:20','email'=>'nullable|email','business'=>'nullable|max:120','service'=>'nullable|max:120','message'=>'nullable|max:1000']);
  ProcessLead::dispatch(Lead::create($d));
  return back()->with('ok','Thanks! We will contact you within one business day.');
 }
 public function leads(){ return view('admin.leads',['leads'=>Lead::latest()->paginate(30)]); }
 public function mark(Lead $lead){ $lead->update(['status'=>'contacted']); return back(); }
 public function sitemap(){
  $u=collect([url('/')])->merge(Service::pluck('slug')->map(fn($s)=>url("/services/$s")));
  $x='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$u->map(fn($i)=>"<url><loc>$i</loc></url>")->join('').'</urlset>';
  return response($x,200,['Content-Type'=>'application/xml']);
 }
}
