<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('services', function (Blueprint $t) {
   $t->id(); $t->string('slug')->unique(); $t->string('title'); $t->string('tagline');
   $t->text('intro'); $t->json('data'); $t->unsignedTinyInteger('sort')->default(0); $t->timestamps();
  });
  Schema::create('leads', function (Blueprint $t) {
   $t->id(); $t->string('name'); $t->string('phone'); $t->string('email')->nullable();
   $t->string('business')->nullable(); $t->string('service')->nullable(); $t->text('message')->nullable();
   $t->string('status')->default('new'); $t->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('leads'); Schema::dropIfExists('services'); }
};
