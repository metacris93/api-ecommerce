<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index()
    {
        Sanctum::actingAs(User::factory()->create());
        Product::factory(5)->create();
        $response = $this->getJson('/api/products');
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        //$response->assertJsonCount(5, 'data.data');
    }
    public function test_create_new_product()
    {
        Sanctum::actingAs(User::factory()->create());
        $data = [
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween(1, 100),
        ];
        $response = $this->postJson('/api/products', $data);

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }
    public function test_update_product()
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();
        $data = [
            'name' => 'Product updated',
            'price' => $this->faker->numberBetween(1, 100),
        ];
        $response = $this->patchJson("/api/products/{$product->getKey()}", $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }
    public function test_show_product()
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }
    public function test_delete_product()
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }
}
