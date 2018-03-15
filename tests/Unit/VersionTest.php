<?php

namespace Tests\Unit;

use MinhD\Repository\Version;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function version_must_know_its_datasource()
    {
        $version = create(Version::class);
        $this->assertEquals($version->record->datasource, $version->datasource);
    }

    /** @test */
    function version_must_have_an_owner_via_record_datasource()
    {
        $version = create(Version::class);
        $this->assertEquals($version->record->datasource->owner, $version->owner);
    }
}
