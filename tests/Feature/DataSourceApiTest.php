<?php

namespace Tests\Feature;

use MinhD\Repository\DataSource;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataSourceApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_all_datasources()
    {
        factory(DataSource::class, 100)->create();

        // GET /
        $result = $this->getJson(route('datasources.index'));

        $result->assertStatus(200);

        // should see 10
        $result->assertJsonCount(10);

        // should see the next link in header
        // $resource->assertHeader('Link');
    }
}
