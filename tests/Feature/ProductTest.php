<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Product, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inertia\Testing\AssertableInertia as Assert;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->products = Product::factory()
                            ->count(20)
                            ->sequence(function ($sequence) { 
                                return [
                                    'product_name' => 'Product ' . ($sequence->index + 1),
                                    'price' => 1000,
                                    'product_description' => 'Description',
                                    'quantity' => 10
                                ];
                            })
                            ->create();
        
    }

    public function test_can_view_products() {
        $this->actingAs($this->user)
            ->get('/products')
            ->assertInertia(function (Assert $assert) { 
                $assert->component('Products/Index')
                ->has('products.data', 10)
                ->has('products.data.0', function(Assert $assert) { 
                    $assert->where('id', 11)
                    ->where('name', 'Product 11')
                    ->where('price', 1000)
                    ->where('description', 'Description')
                    ->where('status', 1);
                })
                ->has('products.data.1', function(Assert $assert) { 
                    $assert->where('id', 20)
                    ->where('name', 'Product 20')
                    ->where('price', 1000)
                    ->where('description', 'Description')
                    ->where('status', 1);
                });
            });
    } // test_can_view_products

    public function test_can_filter_to_view_deleted_products() {
        $this->products->firstWhere('product_name', 'Product 20')->delete();

        $this->actingAs($this->user)
            ->get('/products?trashed=with')
            ->assertInertia(function (Assert $assert) { 
                $assert->component('Products/Index')
                ->has('products.data', 10)
                ->where('products.data.0.name', 'Product 10')
                ->where('products.data.1.name', 'Product 19');
            });
    }
}
