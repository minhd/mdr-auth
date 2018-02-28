<?php

namespace Tests\Feature;

use Laravel\Passport\Passport;
use MinhD\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_blocks_anonymous()
    {
        $response = $this->getJson('/api/user');
        $response->assertStatus(401);
        $response->assertSee("Unauthenticated");
    }

    /** @test */
    function it_shows_currently_logged_in_users()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $response = $this->getJson('/api/user');
        $response->assertStatus(201);
        $response->assertSee($user->name);
    }
}
