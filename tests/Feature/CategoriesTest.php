<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase; // este trait limpia la DB cada vez que se vaya a ejecutar un test.

    public function test_returns_empty_categories_list()
    {
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);
        $response->assertJson([
            'categories' => [],
        ]);
        $response->assertJsonCount(0, 'categories');
    }

    public function test_returns_categories_list()
    {
        Category::factory(5)->create();
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'categories');
    }

    public function test_cannot_create_category_with_wrong_parameters()
    {
        $response = $this->postJson('/api/categories');
        $response->assertStatus(422);

        $response = $this->postJson('/api/categories', [
            'name' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->postJson('/api/categories', [
            'name' => '',
        ]);
        $response->assertStatus(422);

        $response = $this->postJson('/api/categories', [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(200);
        $response = $this->postJson('/api/categories', [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(422);
    }

    public function test_can_create_category()
    {
        
    }
}
