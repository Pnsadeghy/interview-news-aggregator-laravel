<?php

namespace Tests\Feature\User\Feed;

use App\Models\NewsSource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFeedShowTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/api/user/userFeed';

    public function testUserFeedShowEmpty()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson($this->url);

        $response->assertStatus(200);

        $response->assertJsonCount(0, "sources");
        $response->assertJson([
            "data" => [
                "title" => "Default"
            ]
        ]);
    }

    public function testUserFeedShow()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $newsSource = NewsSource::factory()->create();
        $user->defaultFeed->newsSources()->attach($newsSource->id);

        $response = $this->getJson($this->url);

        $response->assertStatus(200);

        $response->assertJsonCount(1, "sources");
    }
}
