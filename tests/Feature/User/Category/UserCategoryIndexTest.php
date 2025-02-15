<?php

namespace Tests\Feature\User\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCategoryIndexTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/api/user/categories';

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
        Category::factory()->disable()->create();
        Category::factory()->create();

        $response = $this->get($this->url);
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
