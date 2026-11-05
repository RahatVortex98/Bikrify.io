<?php
namespace App\Providers;
use App\Models\Service;
use Illuminate\Support\Facades\{Schema,View};
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
 public function register(): void {}
 public function boot(): void {
  View::composer(['home','layouts.app','partials.form'],function($v){
   $v->with('services',Schema::hasTable('services')?Service::orderBy('sort')->get():collect());
  });
 }
}
