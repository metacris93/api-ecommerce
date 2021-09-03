<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_a_product_belongs_to_category()
    {
        Sanctum::actingAs(User::factory()->create());
        $category = Category::factory()->create();
        $product = Product::factory()
            ->for($category)
            ->for(auth()->user(), 'createdBy')
            ->create();
        $this->assertInstanceOf(Category::class, $product->category);
    }
    public function test_a_product_belongs_to_an_administrator()
    {
        $user = Sanctum::actingAs(User::factory()->create());
        $category = Category::factory()->create();
        $product = Product::factory()
            ->for($category)
            ->for(auth()->user(), 'createdBy')
            ->create();
        $this->assertInstanceOf(User::class, $product->createdBy);
    }
}
