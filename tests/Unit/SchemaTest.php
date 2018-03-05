<?php

namespace Tests\Unit;

use MinhD\Repository\Schema;
use MinhD\Repository\SchemaVersion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_schema_can_add_versions()
    {
        $schema = create(Schema::class);
        $schema->versions()->create([
            'title' => 'a sample version',
            'data' => 'some data',
            'status' => SchemaVersion::CURRENT
        ]);
        $this->assertCount(1, $schema->fresh()->versions);
    }

    /** @test */
    function a_schema_can_get_current_version()
    {
        $schema = create(Schema::class);

        $schema->versions()->create([
            'title' => 'v1',
            'data' => 'outdated data',
            'status' => SchemaVersion::SUPERSEDED
        ]);

        $this->assertNull($schema->fresh()->currentVersion);

        $schema->versions()->create([
            'title' => 'v2',
            'data' => 'current data',
            'status' => SchemaVersion::CURRENT
        ]);

        $this->assertNotNull($schema->fresh()->currentVersion());
        $this->assertEquals('v2', $schema->fresh()->currentVersion->title);
    }
}
