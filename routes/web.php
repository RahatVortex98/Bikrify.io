<?php
use App\Http\Controllers\SiteController as S;
use Illuminate\Support\Facades\Route;
Route::get('/',[S::class,'home'])->name('home');
Route::get('/services/{service:slug}',[S::class,'service'])->name('service');
Route::post('/demo',[S::class,'demo'])->middleware('throttle:5,1')->name('demo');
Route::get('/sitemap.xml',[S::class,'sitemap']);
Route::middleware('auth.basic')->prefix('admin')->group(function(){
 Route::get('/leads',[S::class,'leads'])->name('leads');
 Route::patch('/leads/{lead}',[S::class,'mark'])->name('leads.mark');
});
use App\Http\Controllers\CrmController as C;
Route::post('/subscribe',[C::class,'subscribe'])->middleware('throttle:5,1');
Route::get('/api/license/{key}',[C::class,'license'])->middleware('throttle:120,1');
Route::get('/security',fn()=>view('page',['t'=>'Security Center','b'=>'Sensitive customer data such as ID numbers is encrypted at rest. Admin access is password-protected, form submissions are rate-limited, and we recommend regular backups for every system we build.']));
Route::get('/case-studies',fn()=>view('page',['t'=>'Case Studies','b'=>'We are documenting our first projects. Check back soon, or message us to see a live demo.']));
Route::get('/status',function(){ try{ \Illuminate\Support\Facades\DB::select('select 1'); $ok=true; }catch(\Throwable $e){ $ok=false; } return view('page',['t'=>'System Status','b'=>($ok?'Website and database: operational.':'Database check failed.').' Checked '.now()->format('d M Y, h:i A').'.']); });
Route::get('/policies', fn () => view('policies'));
Route::middleware('auth.basic')->prefix('admin')->group(function(){
 Route::get('/prospects',[C::class,'prospects']);
 Route::post('/prospects/import',[C::class,'import']);
 Route::patch('/prospects/{prospect}',[C::class,'stage']);
 Route::get('/customers',[C::class,'customers']);
 Route::get('/customers/new',[C::class,'create']);
 Route::post('/customers',[C::class,'store']);
 Route::post('/customers/{customer}/pay',[C::class,'pay']);
 Route::patch('/customers/{customer}/toggle',[C::class,'toggle']);
 Route::get('/customers/{customer}/photo',[C::class,'photo']);
});
