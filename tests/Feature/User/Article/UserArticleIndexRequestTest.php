<?php

namespace Tests\Feature\User\Article;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\NewsSource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserArticleIndexRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/api/user/articles';

    public function testIndexWithoutParameters() {
        $user = User::factory()->create();
        $this->actingAs($user);

        Article::factory(5)->create();

        $response = $this->postJson($this->url);

        $response->assertStatus(200);

        $response->assertJsonCount(5, "data");

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'slug',
                    'url',
                    'title',
                    'description',
                    'body',
                    'image',
                    'published_at',
                    'source',
                    'categories',
                    'authors',
                ]
            ]
        ]);
    }

    public function testIndexWithInvalidDatabaseParameters() {
        $user = User::factory()->create();
        $this->actingAs($user);

        Article::factory(5)->create();

        $response = $this->postJson($this->url, [
            'sources' => [1],
            'categories' => [1],
            'authors' => [1],
        ]);

        $response->assertStatus(422);
    }

    public function testIndexWithQParameter() {
        $user = User::factory()->create();
        $this->actingAs($user);

        Article::factory()->create([
            'title' => "test World"
        ]);
        Article::factory()->create([
            'description' => "This is test description"
        ]);
        Article::factory()->create([
            'body' => "Test in body"
        ]);
        Article::factory(5)->create();

        $response = $this->postJson($this->url, [
            'q' => "test",
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(3, "data");
    }

    public function testIndexWithSourcesParameter() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $newsSource = NewsSource::factory()->create();
        Article::factory()->create([
            'news_source_id' => $newsSource->id
        ]);
        Article::factory(5)->create();

        $response = $this->postJson($this->url, [
            'sources' => [$newsSource->id],
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(1, "data");
    }

    public function testIndexWithCategoriesParameter() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create();
        Article::factory(5)->create();
        $article->categories()->attach([$category->id]);

        $response = $this->postJson($this->url, [
            'categories' => [$category->id],
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(1, "data");
    }

    public function testIndexWithAuthorsParameter() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $author = Author::factory()->create();
        $article = Article::factory()->create();
        Article::factory(5)->create();
        $article->authors()->attach([$author->id]);

        $response = $this->postJson($this->url, [
            'authors' => [$author->id],
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(1, "data");
    }
}
