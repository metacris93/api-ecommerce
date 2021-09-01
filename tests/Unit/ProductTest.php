<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_a_product_belongs_to_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $this->assertInstanceOf(Category::class, $product->category);
    }
    public function test_a_product_belongs_to_an_administrator()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'created_by' => $user->id,
            'category_id' => $category->id,
        ]);
        $this->assertInstanceOf(User::class, $product->createdBy);
    }
    public function test_a_product_can_be_rated()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'created_by' => $user->id,
            'category_id' => $category->id,
        ]);
        $product->rate($user, 5);
        $this->assertCount(1, $user->rates);
        $this->assertTrue($product->rates->contains('id', $user->id));
    }
}
