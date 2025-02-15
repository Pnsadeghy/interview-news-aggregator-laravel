<?php

namespace Tests\Feature\User\Author;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAuthorIndexTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/api/user/authors';

    public function testEmptyIndex()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get($this->url);
        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    public function testDataIndex()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Author::factory()->disable()->create();
        Author::factory()->create();

        $response = $this->get($this->url);
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
