<?php

namespace Tests\Feature;

use MinhD\Repository\Schema;
use MinhD\Repository\SchemaVersion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchemaVersionApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    function it_shows_some_schema_versions()
    {
        signInAdmin();

        $schema = create(Schema::class);
        for ($i = 1; $i < 6; $i++) {
            $schema->versions()->create([
                'title' => "version $i",
                'data' => "some data for version $i",
                'status' => SchemaVersion::SUPERSEDED
            ]);
        }
        $this->getJson(route('schemas.schemaversions.index', ['schema' => $schema->id]))
            ->assertStatus(200)
            ->assertJsonCount(5);
    }

    /** @test */
    function it_shows_a_single_version_via_schema_route()
    {
        signInAdmin();

        $schema = create(Schema::class);
        $schema->versions()->create([
            'title' => 'a sample version',
            'data' => 'some data',
            'status' => SchemaVersion::CURRENT
        ]);
        $version = $schema->currentVersion;

        $this->getJson(route('schemas.schemaversions.show', ['schema' => $schema->id, 'schemaversion' => $version->id]))
            ->assertStatus(200)
            ->assertSee('a sample version');
    }

    /** @test */
    function it_adds_schema_version()
    {
        signInAdmin();

        $schema = create(Schema::class);
        $result = $this->postJson(route('schemas.schemaversions.store', ['schema' => $schema->id]), [
            'title' => 'a sample version',
            'status' => 'current',
            'data' => 'some data'
        ]);
        $result->assertStatus(201);
        $result->assertSee('a sample version');
    }

    /** @test */
    function it_updates_schema_version()
    {
        signInAdmin();

        $schema = create(Schema::class);
        $version = SchemaVersion::create([
            'title' => 'v1',
            'status' => 'current',
            'data' => 'some data',
            'schema_id' => $schema
        ]);

        $result = $this->putJson(route('schemas.schemaversions.update', [
            'schema' => $schema->id,
            'schemaversion' => $version->id
        ]), [
            'title' => 'v2',
            'status' => 'current',
            'data' => 'some data'
        ]);

        $result->assertStatus(202);
        $result->assertSee("v2");
    }

    /** @test */
    function it_validates_schema_version()
    {
        signInAdmin();

        $schema = create(Schema::class);
        $result = $this->postJson(route('schemas.schemaversions.store', ['schema' => $schema->id]), [
            'title' => 'a sample version',
            'data' => 'some data'
        ]);
        $result->assertStatus(422);
    }

    /** @test */
    function it_deletes_schema_versions()
    {
        signInAdmin();

        $schema = create(Schema::class);
        $version = SchemaVersion::create([
            'title' => 'v1',
            'status' => 'current',
            'data' => 'some data',
            'schema_id' => $schema
        ]);

        $this->deleteJson(route('schemas.schemaversions.destroy', ['schema' => $schema->id, 'version' => $version->id]))
            ->assertStatus(202);
    }

}
