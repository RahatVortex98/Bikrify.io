<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertRedirect(route('home'));
        foreach ([
            '/services/online-store-order-system' => 'order-management-system-for-facebook-sellers',
            '/services/pos-inventory-system' => 'pos-software-bangladesh',
            '/services/custom-erp-automation' => 'custom-erp-software-bangladesh',
        ] as $oldPath => $newSlug) {
            $this->get($oldPath)->assertRedirect(route('service', $newSlug));
        }

        $this->get(route('home'))->assertOk();
    }
}
