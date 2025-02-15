<?php

namespace Tests\Feature\User\Article;

use App\Models\Article;
use App\Models\NewsSource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserArticleFeedRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/api/user/articles/feed';

    public function testFeed() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $newsSource = NewsSource::factory()->create();
        Article::factory(5)->create([
            'news_source_id' => $newsSource->id
        ]);
        Article::factory(5)->create();
        $user->defaultFeed->newsSources()->attach($newsSource->id);

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
}
