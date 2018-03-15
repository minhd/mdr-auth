<?php

namespace Tests\Feature;

use Laravel\Passport\Passport;
use MinhD\Repository\DataSource;
use MinhD\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataSourceApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_some_datasources()
    {
        $user = create(User::class);
        create(DataSource::class, ['user_id' => $user->id], 20);
        signIn($user);

        $result = $this->getJson(route('datasources.index'));
        $result->assertStatus(200);
        $result->assertJsonCount(10);
    }

    /** @test */
    function only_datasource_owned_can_be_listed()
    {
        $user = create(User::class);
        $dataSource1 = create(DataSource::class, ['user_id' => $user->id]);
        $anotherUser = create(User::class);
        $dataSource2 = create(DataSource::class, ['user_id' => $anotherUser->id]);
        signIn($user);

        $this->getJson(route('datasources.index'))
            ->assertStatus(200)
            ->assertJsonCount(1)
            ->assertSee($dataSource1->title)
            ->assertDontSee($dataSource2->title);
    }

    /** @test */
    function it_shows_a_single_datasource()
    {
        $user = create(User::class);
        $dataSource = create(DataSource::class, ['user_id' => $user->id]);
        signIn($user);

        $this->getJson(route('datasources.show', ['datasource' => $dataSource->id]))
            ->assertStatus(200)
            ->assertSee($dataSource->id);
    }

    /** @test */
    function it_shows_link_pagination_on_header()
    {
        $user = create(User::class);
        create(DataSource::class, ['user_id' => $user->id], 30);
        signIn($user);

        // GET /
        $result = $this->getJson(route('datasources.index'));
        $result->assertStatus(200);

        // should see the next link in header
        $result->assertHeader('Link');
        $this->assertContains("next", $result->headers->get('Link'));
        $this->assertContains("last", $result->headers->get('Link'));
        $this->assertContains("first", $result->headers->get('Link'));
    }

    /** @test */
    function it_shows_previous_link_on_page_2()
    {
        $user = create(User::class);
        create(DataSource::class, ['user_id' => $user->id], 30);
        signIn($user);

        $result = $this->getJson(route('datasources.index') . "?page=2");
        $result->assertHeader('Link');
        $this->assertContains("prev", $result->headers->get('Link'));
    }

    /** @test */
    public function it_blocks_the_right_route()
    {
        $this->postJson(route('datasources.store'), [])
            ->assertStatus(401)->assertSee('Unauthenticated');

        $this->putJson(route('datasources.update', ['datasource' => 1]), [])
            ->assertStatus(401)->assertSee('Unauthenticated');

        $this->deleteJson(route('datasources.destroy', ['datasource' => 1]), [])
            ->assertStatus(401)->assertSee('Unauthenticated');
    }

    /** @test */
    function it_creates_datasource()
    {
        signIn();

        $result = $this->postJson(route('datasources.store'), [
            'title' => 'A sample data source',
            'description' => 'something'
        ]);

        $result->assertStatus(201);
        $result->assertSee("A sample data source");
    }

    /** @test */
    function it_validates_datasource_creation()
    {
        signIn();

        $result = $this->postJson(route('datasources.store'), []);
        $result->assertStatus(422);
        $result->assertSee("title");
        $result->assertSee("required");
    }

    /** @test */
    function it_update_datasource()
    {
        $dataSource = create(DataSource::class);
        signIn($dataSource->owner);

        $result = $this->putJson(route('datasources.update', ['datasource' => $dataSource->id]), [
            'title' => 'title changed',
            'description' => 'description changed'
        ]);
        $result->assertStatus(202);
        $result->assertSee('title changed');
        $result->assertSee('description changed');
    }

    /** @test */
    function it_disallow_updating_datasource_you_dont_own()
    {
        $dataSource = create(DataSource::class);
        $notOwner = signIn();
        Passport::actingAs($notOwner);

        $result = $this->putJson(route('datasources.update', ['datasource' => $dataSource->id]), [
            'title' => 'title changed',
            'description' => 'description changed'
        ]);
        $result->assertStatus(403);
    }

    /** @test */
    function it_can_delete_datasource()
    {
        $dataSource = create(DataSource::class);
        signIn($dataSource->owner);

        $this->deleteJson(route('datasources.destroy', ['datasource' => $dataSource->id]))
            ->assertStatus(202);

        $this->assertNull(DataSource::find($dataSource->id));
    }
}
