<?php

namespace Tests\Feature\User\NewsSource;

use App\Models\NewsSource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestNewsSourceIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    private string $url = '/api/user/newsSources';

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
        Newssource::factory()->disable()->create();
        Newssource::factory()->create();

        $response = $this->get($this->url);
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
