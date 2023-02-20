<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_empty_posts()
    {
        $this->getJson(route('posts.index'))
            ->assertStatus(200)
            ->assertJsonCount(0, 'posts');
    }

    public function test_list_posts()
    {
        $category = Category::factory()->create();
        $posts = Post::factory(5)->for($category)->create();
        $this->getJson(route('posts.index'))
            ->assertStatus(200)
            ->assertJsonCount(5, 'posts');
    }

    public function test_list_category_posts()
    {
        $category1 = Category::factory()
            ->hasPosts(5)
            ->create();
        $category2 = Category::factory()->create();

        $this->getJson(route('category.posts', ['category' => $category1->id]))
            ->assertStatus(200)
            ->assertJsonCount(5, 'posts');
        $this->getJson(route('category.posts', ['category' => $category2->id]))
            ->assertStatus(200)
            ->assertJsonCount(0, 'posts');
    }
}
