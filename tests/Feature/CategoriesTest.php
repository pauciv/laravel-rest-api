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
        $response = $this->getJson(route('categories.index'));
        $response->assertStatus(200);
        $response->assertJson([
            'categories' => [],
        ]);
        $response->assertJsonCount(0, 'categories');
    }

    public function test_returns_categories_list()
    {
        Category::factory(5)->create();
        $response = $this->getJson(route('categories.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'categories');
    }

    public function test_cannot_create_category_with_wrong_parameters()
    {
        $response = $this->postJson(route('categories.store'));
        $response->assertStatus(422);

        $response = $this->postJson(route('categories.store'), [
            'name' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->postJson(route('categories.store'), [
            'name' => '',
        ]);
        $response->assertStatus(422);

        $response = $this->postJson(route('categories.store'), [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(200);
        $response = $this->postJson(route('categories.store'), [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(422);
    }

    public function test_can_create_category()
    {
        $response = $this->postJson(route('categories.store'), [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'category' => [
                'id',
                'name',
                'created_at',
                'updated_at'
            ],
        ]);

        $this->assertEquals('Test 1', $response->json('category.name'));
    }

    public function test_cannot_find_missing_category()
    {
        $response = $this->getJson(route('categories.show', ['category' => 1]));
        $response->assertStatus(404);
    }

    public function test_returns_correct_category()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $response1 = $this->getJson(route('categories.show', ['category' => $category1->id]));
        $response1->assertStatus(200);
        $response2 = $this->getJson(route('categories.show', ['category' => $category2->id]));
        $response2->assertStatus(200);

        $this->assertEquals($response1->json('category.id'), $category1->id);
        $this->assertEquals($response1->json('category.name'), $category1->name);

        $this->assertEquals($response2->json('category.id'), $category2->id);
        $this->assertEquals($response2->json('category.name'), $category2->name);
    }

    public function test_cannot_update_missing_category()
    {
        $response = $this->putJson(route('categories.update', ['category' => 1]), [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(404);
    }

    public function test_cannot_update_category_with_wrong_parameters()
    {
        $category = Category::factory()->create();
        $category2 = Category::factory()->create();
        $response = $this->putJson(route('categories.update', ['category' => $category->id]));
        $response->assertStatus(422);

        $response = $this->putJson(route('categories.update', ['category' => $category->id]), [
            'name' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->putJson(route('categories.update', ['category' => $category->id]), [
            'name' => '',
        ]);
        $response->assertStatus(422);

        $response = $this->putJson(route('categories.update', ['category' => $category->id]), [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(200);
        $response = $this->putJson(route('categories.update', ['category' => $category->id]), [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(200);

        $response = $this->putJson(route('categories.update', ['category' => $category->id]), [
            'name' => $category2->name,
        ]);
        $response->assertStatus(422);
    }

    public function test_can_update_category()
    {
        $category = Category::factory()->create();
        $response = $this->putJson(route('categories.update', ['category' => $category->id]), [
            'name' => 'Test 1',
        ]);
        $response->assertStatus(200);
        $this->assertEquals($response->json('category.name'), 'Test 1');
    }

    public function test_can_delete_category()
    {
        $categories = Category::factory(2)->create();
        $response = $this->delete(route('categories.destroy', ['category' => $categories->first()->id]));
        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
        $listResponse = $this->getJson('/api/categories');
        $listResponse->assertJsonCount(1, 'categories');

        $response = $this->delete(route('categories.destroy', ['category' => $categories->first()->id]));
        $response->assertStatus(404);
    }
}
