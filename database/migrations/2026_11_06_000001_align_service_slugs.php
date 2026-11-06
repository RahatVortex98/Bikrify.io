<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            'online-store-order-system' => 'order-management-system-for-facebook-sellers',
            'pos-inventory-system' => 'pos-software-bangladesh',
            'custom-erp-automation' => 'custom-erp-software-bangladesh',
        ] as $old => $new) {
            if (! DB::table('services')->where('slug', $new)->exists()) {
                DB::table('services')->where('slug', $old)->update(['slug' => $new]);
            }

            DB::table('home_build_items')->where('url', '/services/'.$old)
                ->update(['url' => '/services/'.$new]);
        }
    }

    public function down(): void
    {
        // Keep canonical slugs: existing redirects depend on them.
    }
};
