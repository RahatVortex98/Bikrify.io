<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('prospects', function (Blueprint $t) {
   $t->id(); $t->string('page_name'); $t->string('fb_link')->nullable(); $t->unsignedBigInteger('followers')->nullable();
   $t->string('phone')->nullable()->index(); $t->string('stage')->default('new')->index(); $t->text('note')->nullable();
   $t->timestamp('last_contact_at')->nullable(); $t->timestamps();
  });
  Schema::create('customers', function (Blueprint $t) {
   $t->id(); $t->foreignId('prospect_id')->nullable(); $t->string('name'); $t->string('phone'); $t->string('site_url')->nullable();
   $t->string('plan'); $t->unsignedInteger('price')->nullable(); $t->unsignedInteger('monthly_fee')->nullable();
   $t->text('nid')->nullable(); $t->string('photo')->nullable(); $t->string('pay_method')->nullable(); $t->string('pay_account')->nullable();
   $t->date('paid_until')->nullable(); $t->string('status')->default('active'); $t->string('license_key')->unique(); $t->timestamps();
  });
  Schema::create('payments', function (Blueprint $t) {
   $t->id(); $t->foreignId('customer_id'); $t->unsignedInteger('amount'); $t->date('paid_on'); $t->timestamps();
  });
  Schema::create('subscribers', function (Blueprint $t) { $t->id(); $t->string('email')->unique(); $t->timestamps(); });
 }
 public function down(): void { foreach(['subscribers','payments','customers','prospects'] as $n) Schema::dropIfExists($n); }
};
