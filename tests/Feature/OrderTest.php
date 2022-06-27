<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\{Order, User};

class OrderTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->orders = Order::factory()->count(15)->create();
    }

    public function test_can_view_orders() {
        $this->actingAs($this->user)
            ->get('/orders')
            ->assertInertia(function (Assert $assert) { 
                $assert->component('Orders/Index')
                ->has('orders', 15);
            });
    } // test_can_view_products
}
