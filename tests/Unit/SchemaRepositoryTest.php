<?php

namespace Tests\Unit;

use MinhD\Exceptions\SchemaNotFound;
use MinhD\Repository\Schema;
use MinhD\Repository\SchemaRepository;
use Tests\TestCase;

class SchemaRepositoryTest extends TestCase
{
    /** @test */
    function loading_an_unknown_schema()
    {
        $this->expectException(SchemaNotFound::class);
        (new SchemaRepository())->resolve("unknown");
    }

    /** @test */
    function it_can_resolve_to_a_schema()
    {
        $schema = (new SchemaRepository())->resolve("json-ld");
        $this->assertEquals(Schema::class, get_class($schema));
    }

    /** @test */
    function a_schema_can_validate_a_payload()
    {
        $schema = (new SchemaRepository())->resolve("json-ld");
        $this->assertTrue($schema->validate(""));
    }
}
