<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
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

        $product = Product::factory()
            ->count(5)
            ->for(Category::factory()->create())
            ->create();

        $response = $this->getJson('/api/v1/products');
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(5, 'data.data');
    }
    public function test_create_new_product()
    {
        Sanctum::actingAs(User::factory()->create());
        $category = Category::factory()->create();
        $data = [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'category_id' => $category->id,
            'created_by' => auth()->user()->id,
        ];
        $response = $this->postJson('/api/v1/products', $data);

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }
    public function test_update_product()
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()
            ->for(Category::factory()->create())
            ->create();
        $category = Category::factory()->create();

        $data = [
            'name' => 'Product updated',
            'price' => $this->faker->randomFloat(2, 1, 100),
            'category_id' => $category->id,
        ];
        $response = $this->patchJson("/api/v1/products/{$product->getKey()}", $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }
    public function test_show_product()
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()
            ->for(Category::factory()->create())
            ->create();

        $response = $this->getJson("/api/v1/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }
    public function test_delete_product()
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()
            ->for(Category::factory()->create())
            ->create();

        $response = $this->deleteJson("/api/v1/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }
}
