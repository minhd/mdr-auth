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

    /** @test */
    function it_shows_some_schema_versions()
    {
        $schema = create(Schema::class);
        for ($i = 1; $i < 6; $i++) {
            $schema->versions()->create([
                'title' => "version $i",
                'data' => "some data for version $i",
                'status' => SchemaVersion::SUPERSEDED
            ]);
        }
        $this->getJson(route('schemas.versions.index', ['schema' => $schema->id]))
            ->assertStatus(200)
            ->assertJsonCount(5);
    }

    /** @test */
    function it_shows_a_single_version_via_schema_route()
    {
        $schema = create(Schema::class);
        $schema->versions()->create([
            'title' => 'a sample version',
            'data' => 'some data',
            'status' => SchemaVersion::CURRENT
        ]);
        $version = $schema->currentVersion;

        $this->getJson(route('schemas.versions.show', ['schema' => $schema->id, 'version' => $version->id]))
            ->assertStatus(200)
            ->assertSee('a sample version');
    }

}
