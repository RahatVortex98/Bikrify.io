<?php
namespace App\Http\Controllers;
use App\Jobs\ProcessLead;
use App\Models\{HomeBuildItem,Lead,Post,Service};
use Illuminate\Http\Request;
class SiteController extends Controller {
 public function home(){
  return view('home',[
   'latestPosts'=>Post::published()->latest('published_at')->limit(8)->get(),
   'homeBuildItems'=>HomeBuildItem::orderBy('sort')->orderBy('id')->get(),
  ]);
 }
 public function service(Service $service){
  return view('service',[
   's'=>$service,
   'relatedServices'=>Service::whereKeyNot($service->getKey())->orderBy('sort')->get(),
  ]);
 }
 public function demo(Request $r){
  if ($r->filled('website')) return back();
  $d=$r->validate(['name'=>'required|max:80','phone'=>'required|max:20','email'=>'nullable|email','business'=>'nullable|max:120','service'=>'nullable|max:120','message'=>'nullable|max:1000']);
  ProcessLead::dispatch(Lead::create($d));
  return back()->with('ok','Thanks! We will contact you within one business day.');
 }
 public function leads(){ return view('admin.leads',['leads'=>Lead::latest()->paginate(30)]); }
 public function mark(Lead $lead){ $lead->update(['status'=>'contacted']); return back(); }
 public function sitemap(){
  $entries=collect([['url'=>route('home'),'lastmod'=>null]]);
  Service::orderBy('sort')->get(['slug','updated_at'])->each(fn($service)=>$entries->push([
   'url'=>route('service',$service->slug),
   'lastmod'=>$service->updated_at,
  ]));
  $latestPost=Post::published()->latest('published_at')->first();
  $entries->push(['url'=>route('blog.index'),'lastmod'=>$latestPost?->updated_at]);
  Post::published()->get(['slug','updated_at'])->each(fn($post)=>$entries->push([
   'url'=>route('blog.show',$post->slug),
   'lastmod'=>$post->updated_at,
  ]));
  $urls=$entries->map(function($entry){
   $location=htmlspecialchars($entry['url'],ENT_XML1|ENT_QUOTES,'UTF-8');
   $lastmod=$entry['lastmod']?'<lastmod>'.$entry['lastmod']->toAtomString().'</lastmod>':'';
   return "<url><loc>$location</loc>$lastmod</url>";
  })->join('');
  $x='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$urls.'</urlset>';
  return response($x,200,['Content-Type'=>'application/xml']);
 }
}
