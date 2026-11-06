<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_build_items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('description', 500);
            $table->string('url', 2048);
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });

        if (Schema::hasTable('services')) {
            DB::table('services')->orderBy('sort')->get()->each(function ($service) {
                DB::table('home_build_items')->insert([
                    'title' => $service->title,
                    'description' => $service->tagline,
                    'url' => '/services/'.$service->slug,
                    'sort' => $service->sort,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('home_build_items');
    }
};
