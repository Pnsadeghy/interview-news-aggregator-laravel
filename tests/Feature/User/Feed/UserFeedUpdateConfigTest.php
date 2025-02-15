<?php

namespace Tests\Feature\User\Feed;

use App\Models\NewsSource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFeedUpdateConfigTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/api/user/userFeed/config';

    public function testUserFeedUpdateConfigWithInvalidData()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->putJson($this->url, [
           "sources" => [1]
        ]);

        $response->assertStatus(422);
    }

    public function testUserFeedUpdateConfigWithValidData()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertDatabaseCount("user_feed_news_sources", 0);

        $newsSource = NewsSource::factory()->create();

        $response = $this->putJson($this->url, [
           "sources" => [$newsSource->id]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount("user_feed_news_sources", 1);
    }
}
