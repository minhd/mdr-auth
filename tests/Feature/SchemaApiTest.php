<?php

namespace Tests\Feature;

use Laravel\Passport\Passport;
use MinhD\Repository\Schema;
use MinhD\Role;
use MinhD\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchemaApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    function it_shows_schemas()
    {
        factory(Schema::class, 20)->create();
        $result = $this->getJson(route('schemas.index'));
        $result->assertStatus(200);
        $result->assertJsonCount(20);
    }

    // TODO: it shows single schema

    /** @test */
    function it_blocks_the_right_route()
    {
        $this->postJson(route('schemas.store'), [])
            ->assertStatus(401)->assertSee('Unauthenticated');

        $this->putJson(route('schemas.update', ['schema' => 1]), [])
            ->assertStatus(401)->assertSee('Unauthenticated');

        $this->deleteJson(route('schemas.destroy', ['schema' => 1]), [])
            ->assertStatus(401)->assertSee('Unauthenticated');
    }

    /** @test */
    function it_creates_schema()
    {
        $user = factory(User::class)->create();
        $user->addRole('admin');
        Passport::actingAs($user);

        $result = $this->postJson(route('schemas.store'), [
            'title' => 'A sample schema',
            'description' => 'something',
            'shortcode' => 'a-sample',
            'url' => 'http://example.com'
        ]);
        $result->assertStatus(201);
        $result->assertSee("A sample schema");
    }

    /** @test */
    function it_validates_schema_creation()
    {
        $user = factory(User::class)->create();
        $user->addRole('admin');
        Passport::actingAs($user);
        // TODO: superuser

        $result = $this->postJson(route('schemas.store'), []);
        $result->assertStatus(422);
        $result->assertSee("title");
        $result->assertSee("required");
    }

    /** @test */
    function it_updates_schema()
    {
        $schema = factory(Schema::class)->create();

        $user = factory(User::class)->create();
        $user->addRole('admin');
        Passport::actingAs($user);

        $result = $this->putJson(route('schemas.update', ['schema' => $schema->id]), [
            'title' => 'title changed',
            'description' => 'description changed'
        ]);
        $result->assertStatus(202);
        $result->assertSee('title changed');
        $result->assertSee('description changed');
    }

    /** @test */
    function it_disallow_updating_schema_without_superuser()
    {
        $schema = factory(Schema::class)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $result = $this->putJson(route('schemas.update', ['schema' => $schema->id]), [
            'title' => 'title changed',
            'description' => 'description changed'
        ]);
        $result->assertStatus(401);
    }

    /** @test */
    function it_deletes_schema()
    {
        $schema = factory(Schema::class)->create();
        $user = factory(User::class)->create();
        $user->addRole('admin');
        Passport::actingAs($user);

        $this->deleteJson(route('schemas.destroy', ['schema'=>$schema->id]))
            ->assertStatus(202);

        $this->assertNull(Schema::find($schema->id));
    }
}
