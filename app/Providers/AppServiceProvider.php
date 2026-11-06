<?php
namespace App\Providers;
use App\Models\Service;
use Illuminate\Support\Facades\{Schema,View};
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
 public function register(): void {}
 public function boot(): void {
  foreach (['admin-login','public-demo','public-subscribe'] as $limiter) {
   \Illuminate\Support\Facades\RateLimiter::for($limiter, fn(\Illuminate\Http\Request $request)=>\Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip()));
  }
  View::composer(['home','layouts.app','partials.form'],function($v){
   $v->with('services',Schema::hasTable('services')?Service::orderBy('sort')->get():collect());
  });
 }
}
